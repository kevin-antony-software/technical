<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankDetail;
use App\Models\Cash;
use App\Models\Customer;
use App\Models\RepairJob;
use Carbon\Carbon;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function payment_receive($payment_id)
    {

        $affected = DB::table('payments')
            ->where('id', $payment_id)
            ->update(['status' => 'Accounts received']);

        $payment = Payment::where('id', $payment_id)->first();

        if ($payment->method == 'Cash') {
            $cashBalance = DB::table('cashes')->orderBy('id', 'desc')->first('balance');

            $newBalance = $cashBalance->balance + $payment->amount;
            $cash = new Cash();
            $cash->balance = $newBalance;
            $cash->category = "payment ID - ". $payment->id;
            $cash->amount = $payment->amount;
            $cash->payment_id = $payment->id;
            $cash->save();

        } else if ($payment->method == 'BankTransfer') {
            $bankBalance = DB::table('banks')->where('id', $payment->bank_id)->value('balance');

            $newBalance = $bankBalance + $payment->amount;

            $affected = DB::table('banks')
                ->where('id', $payment->bank_id)
                ->update(['balance' => $newBalance]);

                $bankDetail = new BankDetail();
                $bankDetail->bank_id = $payment->bank_id;
                $bankDetail->payment_id = $payment->id;
                $bankDetail->amount = $payment->amount;
                $bankDetail->credit_amount = $payment->amount;
                $bankDetail->bank_balance = $newBalance;
                $bankDetail->reason = "payment ID - ". $payment->id . " - cus - ". $payment->customer_name;
                $bankDetail->save();

        }

        return redirect()->route('payment.index')->with('message', 'payment - ' . $payment_id . ' received');
    }

    public function link($id)
    {
        $payment = Payment::where('id', $id)->first();
        $arr['jobs'] = RepairJob::select('id', 'due_amount')->where('customer_id', $payment->customer_id)->get();
        $arr['payment'] = $payment;
        return view('admin.jobLink.create')->with($arr);
    }

    public function link_job(Request $request, $id){
        $paymentID = $request->paymentID;
        $payment = Payment::where('id', $paymentID)->first();

        for ($i = 1; $i <= 15; $i++) {
            $jobID = "jobID" . $i;
            $dueAmount = 'dueAmount' . $i;
            $paidAmount = "paidAmount" . $i;

            if ($request->$jobID != "") {
                $validatedData = $request->validate([
                    $dueAmount => 'required|numeric',
                    $paidAmount => 'required|numeric',
                ]);
            }
        }

        if ($payment->method == 'Cash' || $payment->method == 'BankTransfer') {
            for ($i = 1; $i <= 15; $i++) {
                $jobID = "jobID" . $i;
                $dueAmount = 'dueAmount' . $i;
                $paidAmount = "paidAmount" . $i;
                if ($request->$jobID != "") {
                    DB::table('repair_jobs')->where('id', $request->$jobID)->decrement('due_amount', $request->$paidAmount);
                    $job = RepairJob::where('id', $request->$jobID)->first();

                    DB::table('invoice_payment')->insert([
                        'payment_id' => $payment->id,
                        'payment_date' => $payment->created_at,
                        'payment_method' => $payment->method,
                        'job_id' => $job->id,
                        'job_closed_date' => $job->jobClosedTime,
                        'customer_id' => $job->customer_id,
                        'customer_name' => $job->customer_name,
                        'commission_owner' => 0,
                        'amount' => $request->$paidAmount,
                        'balance' => 0,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    DB::table('payments')->where('id', $payment->id)->decrement('balanceToAllocate', $request->$paidAmount);
                    DB::table('payments')->where('id', $payment->id)->increment('allocatedToInvoice', $request->$paidAmount);
                    if (DB::table('jobs')->where('id', $job->id)->value('dueAmount') < 1) {
                        DB::table('jobs')
                            ->where('id', $request->$jobID)
                            ->update(['payment_status' => 'paid']);
                    }
                }
            }
        }
        if ($payment->method == 'Cheque') {
            $paymentLinks = array();
            $cheques = Cheque::where('payment_id', $paymentID)->orderBy('chequeDate', 'asc')->get();
            for ($i = 1; $i <= 15; $i++) {
                $jobID = "jobID" . $i;
                $dueAmount = 'dueAmount' . $i;
                $paidAmount = "paidAmount" . $i;
                if ($request->$jobID != "") {
                    $paymentLinks[$i - 1] = array(
                        'jobID' => $request->$jobID,
                        'amount' => $request->$paidAmount,
                        'balance' => $request->$paidAmount
                    );
                }
            }

            $keys = array_column($paymentLinks, 'jobID');
            array_multisort($keys, SORT_ASC, $paymentLinks);

            for ($j = 0; $j < count($cheques); $j++) {
                for ($k = 0; $k < count($paymentLinks); $k++) {
                    if ($cheques[$j]->balance == 0) {
                        break;
                    }
                    if ($paymentLinks[$k]['balance'] != 0) {
                        if ($cheques[$j]->balance > $paymentLinks[$k]['balance']) {


                            DB::table('repair_jobs')->where('id', $paymentLinks[$k]['jobID'])->decrement('due_amount', $paymentLinks[$k]['balance']);
                            $job = RepairJob::where('id', $paymentLinks[$k]['jobID'])->first();

                            DB::table('invoice_payment')->insert([
                                'payment_id' => $payment->id,
                                'payment_date' => $payment->created_at,
                                'payment_method' => $payment->method,
                                'cheque_id' => $cheques[$j]->id,
                                'job_id' => $job->id,
                                'job_closed_date' => $job->jobClosedTime,
                                'customer_id' => $job->customer_id,
                                'customer_name' => $job->customer_name,
                                'commission_owner' => 0,
                                'amount' => $paymentLinks[$k]['balance'],
                                'balance' => 0,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                            DB::table('payments')->where('id', $request->paymentID)->decrement('balanceToAllocate', $paymentLinks[$k]['balance']);
                            DB::table('payments')->where('id', $request->paymentID)->increment('allocatedToInvoice', $paymentLinks[$k]['balance']);
                            if (DB::table('jobs')->where('id', $job->id)->value('dueAmount') < 1) {
                                DB::table('jobs')
                                    ->where('id', $job->id)
                                    ->update(['payment_status' => 'paid']);
                            }

                            $cheques[$j]->balance = $cheques[$j]->balance - $paymentLinks[$k]['balance'];
                            $cheques[$j]->save();
                            $paymentLinks[$k]['balance'] = 0;
                        } else if ($cheques[$j]->balance < $paymentLinks[$k]['balance']) {

                            DB::table('jobs')->where('id', $paymentLinks[$k]['jobID'])->increment('PaidAmount', $cheques[$j]->balance);
                            DB::table('jobs')->where('id', $paymentLinks[$k]['jobID'])->decrement('dueAmount', $cheques[$j]->balance);
                            $job = Job::where('id', $paymentLinks[$k]['jobID'])->first();

                            DB::table('invoice_payment')->insert([
                                'payment_id' => $payment->id,
                                'payment_date' => $payment->created_at,
                                'payment_method' => $payment->method,
                                'cheque_id' => $cheques[$j]->id,
                                'job_id' => $job->id,
                                'job_closed_date' => $job->jobClosedTime,
                                'customer_id' => $job->customer_id,
                                'customer_name' => $job->customer_name,
                                'commission_owner' => 0,
                                'amount' => $cheques[$j]->balance,
                                'balance' => 0,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                            DB::table('payments')->where('id', $request->paymentID)->decrement('balanceToAllocate', $cheques[$j]->balance);
                            DB::table('payments')->where('id', $request->paymentID)->increment('allocatedToInvoice', $cheques[$j]->balance);
                            if (DB::table('jobs')->where('id', $job->id)->value('dueAmount') < 1) {
                                DB::table('jobs')
                                    ->where('id', $job->id)
                                    ->update(['payment_status' => 'paid']);
                            }

                            $paymentLinks[$k]['balance'] = $paymentLinks[$k]['balance'] - $cheques[$j]->balance;
                            $cheques[$j]->balance = 0;
                            $cheques[$j]->save();
                        } else if ($cheques[$j]->balance == $paymentLinks[$k]['balance']) {

                            DB::table('jobs')->where('id', $paymentLinks[$k]['jobID'])->increment('PaidAmount', $cheques[$j]->balance);
                            DB::table('jobs')->where('id', $paymentLinks[$k]['jobID'])->decrement('dueAmount', $cheques[$j]->balance);
                            $job = Job::where('id', $paymentLinks[$k]['jobID'])->first();

                            DB::table('invoice_payment')->insert([
                                'payment_id' => $payment->id,
                                'payment_date' => $payment->created_at,
                                'payment_method' => $payment->method,
                                'cheque_id' => $cheques[$j]->id,
                                'job_id' => $job->id,
                                'job_closed_date' => $job->jobClosedTime,
                                'customer_id' => $job->customer_id,
                                'customer_name' => $job->customer_name,
                                'commission_owner' => 0,
                                'amount' => $cheques[$j]->balance,
                                'balance' => 0,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                            DB::table('payments')->where('id', $request->paymentID)->decrement('balanceToAllocate', $cheques[$j]->balance);
                            DB::table('payments')->where('id', $request->paymentID)->increment('allocatedToInvoice', $cheques[$j]->balance);
                            if (DB::table('jobs')->where('id', $job->id)->value('dueAmount') < 1) {
                                DB::table('jobs')
                                    ->where('id', $job->id)
                                    ->update(['payment_status' => 'paid']);
                            }

                            $cheques[$j]->balance = 0;
                            $cheques[$j]->save();
                            $paymentLinks[$k]['balance'] = 0;
                        }
                    }
                }
            }
        }

        return redirect()->route('payment.index');
    }

    public function index()
    {
        $arr['payments'] = Payment::orderBy('id', 'desc')->paginate(100);
        return view('admin.payment.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $arr['customers'] = Customer::select('id', 'name')->orderBy('name', 'asc')->get();
        $arr['banks'] = Bank::select('id', 'name')->get();
        return view('admin.payment.create')->with($arr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
