<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankDetail;
use App\Models\Cash;
use App\Models\Cheque;
use App\Models\Customer;
use App\Models\RepairJob;
use Carbon\Carbon;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\PDF;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function print($id)
    {
        $payment = Payment::where('id', $id)->first();
        $arr['payment'] = $payment;
        $arr['customer'] = Customer::where('id', $payment->customer_id)->first();
        $pdf = PDF::loadView('admin.payment.print', $arr);
        return $pdf->download('payment.pdf');
    }

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
        $paymentID = $id;
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

                    DB::table('payment_repair_job_links')->insert([
                        'payment_id' => $payment->id,
                        'repair_job_id' => $job->id,
                        'amount' => $request->$paidAmount,
                        'created_at' => Carbon::now(),
                        'updated_at' => Carbon::now(),
                    ]);
                    DB::table('payments')->where('id', $payment->id)->decrement('balance_to_allocate', $request->$paidAmount);
                    DB::table('payments')->where('id', $payment->id)->increment('allocated_to_job', $request->$paidAmount);
                }
            }
        }
        if ($payment->method == 'Cheque') {
            $paymentLinks = array();
            $cheques = Cheque::where('payment_id', $paymentID)->orderBy('cheque_date', 'asc')->get();
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

                            DB::table('payment_repair_job_links')->insert([
                                'payment_id' => $payment->id,
                                'repair_job_id' => $job->id,
                                'amount' => $paymentLinks[$k]['balance'],
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                            DB::table('payments')->where('id', $request->paymentID)->decrement('balance_to_allocate', $paymentLinks[$k]['balance']);
                            DB::table('payments')->where('id', $request->paymentID)->increment('allocated_to_job', $paymentLinks[$k]['balance']);


                            $cheques[$j]->balance = $cheques[$j]->balance - $paymentLinks[$k]['balance'];
                            $cheques[$j]->save();
                            $paymentLinks[$k]['balance'] = 0;
                        } else if ($cheques[$j]->balance < $paymentLinks[$k]['balance']) {


                            DB::table('jobs')->where('id', $paymentLinks[$k]['jobID'])->decrement('due_amount', $cheques[$j]->balance);
                            $job = RepairJob::where('id', $paymentLinks[$k]['jobID'])->first();

                            DB::table('payment_repair_job_links')->insert([
                                'payment_id' => $payment->id,
                                'repair_job_id' => $job->id,
                                'amount' => $cheques[$j]->balance,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                            DB::table('payments')->where('id', $request->paymentID)->decrement('balance_to_allocate', $cheques[$j]->balance);
                            DB::table('payments')->where('id', $request->paymentID)->increment('allocated_to_job', $cheques[$j]->balance);

                            $paymentLinks[$k]['balance'] = $paymentLinks[$k]['balance'] - $cheques[$j]->balance;
                            $cheques[$j]->balance = 0;
                            $cheques[$j]->save();

                        } else if ($cheques[$j]->balance == $paymentLinks[$k]['balance']) {

                                                       DB::table('jobs')->where('id', $paymentLinks[$k]['jobID'])->decrement('due_amount', $cheques[$j]->balance);
                            $job = RepairJob::where('id', $paymentLinks[$k]['jobID'])->first();

                            DB::table('payment_repair_job_links')->insert([
                                'payment_id' => $payment->id,
                                'repair_job_id' => $job->id,
                                'amount' => $cheques[$j]->balance,
                                'created_at' => Carbon::now(),
                                'updated_at' => Carbon::now(),
                            ]);
                            DB::table('payments')->where('id', $request->paymentID)->decrement('balance_to_allocate', $cheques[$j]->balance);
                            DB::table('payments')->where('id', $request->paymentID)->increment('allocated_to_job', $cheques[$j]->balance);

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
        $validatedData = $request->validate([
            'TotalAmount' => 'required|numeric',
            'customer_name' => 'required',
        ]);

        if (DB::table('customers')->where('name', $request->customer_name)->doesntExist()) {
            return redirect()->route('payment.create')->with('error', 'no customer with that name')->withInput();
        }


        $customerID = Customer::where('name', $request->customer_name)->value('id');
        if ($request->Method == 'Cheque') {
            for ($i = 1; $i < 20; $i++) {
                $chequeNo = 'chequeNo' . $i;
                $bankNo = 'bankNo' . $i;
                $branchNo = 'branchNo' . $i;
                $chequeAmount = 'chequeAmount' . $i;
                $chequeDate = 'chequeDate' . $i;
                if (
                    $request->$chequeNo != '' ||
                    $request->$bankNo != '' ||
                    $request->$branchNo != '' ||
                    $request->$chequeAmount != '' ||
                    $request->$chequeDate != ''
                ) {
                    $validatedData = $request->validate([
                        $chequeNo => 'required|numeric',
                        $bankNo => 'required|numeric',
                        $branchNo => 'required|numeric',
                        $chequeAmount => 'required|numeric',
                        $chequeDate => 'required',
                    ]);
                }
            }
        }
        $idIN = DB::select("SHOW TABLE STATUS LIKE 'payments'");
        $next_id = $idIN[0]->Auto_increment;

        if ($request->Method == 'Cheque') {
            for ($j = 1; $j < 20; $j++) {
                $chequeNo = 'chequeNo' . $j;
                $bankNo = 'bankNo' . $j;
                $branchNo = 'branchNo' . $j;
                $chequeAmount = 'chequeAmount' . $j;
                $chequeDate = 'chequeDate' . $j;

                if ($request->$chequeNo != '') {
                    $cheque = new Cheque();
                    $cheque->payment_id = $next_id;
                    $cheque->cheque_number = $request->$chequeNo;
                    $cheque->cheque_bank = $request->$bankNo;
                    $cheque->cheque_branch = $request->$branchNo;
                    $cheque->amount = $request->$chequeAmount;
                    $cheque->cheque_date = $request->$chequeDate;
                    $cheque->customer_id = $customerID;
                    $cheque->status = 'pending';
                    $cheque->balance = $request->$chequeAmount;
                    $cheque->save();
                }
            }
        }
        $payment = new Payment();
        $user = Auth::user();
        $payment->user_id = $user->id;
        $payment->status = 'with sales';
        $payment->method = $request->Method;
        $payment->amount = $request->TotalAmount;
        $payment->allocated_to_job = 0;
        $payment->balance_to_allocate = $request->TotalAmount;
        $payment->customer_id = $customerID;
        if ($request->Method == 'BankTransfer') {
            $payment->bank_id = $request->bank;
        }
        $payment->save();

        $textMessage = "Thank you! ";
       // $customerMobileNum = (mysqli_fetch_assoc(mysqli_query($conn, "SELECT mobile FROM customers WHERE customerName = '$customer'")))['mobile'];
       $BossMobileNum = Customer::where('name', $request->customer_name)->value('mobile');

        $textMessage = "Thank you! " . $request->customer_name . " for the payment of Rs. " . $request->TotalAmount . ". Regards, K & K International Lanka Pvt Ltd";
        $textBossMobile = "94" . $BossMobileNum;

        if ($textBossMobile) {
            // echo "<br></br><br></br>";
            // echo $textBossMobile;

            $user = "94777696922";
            $password = "5177";
            $text = urlencode($textMessage);
            $to = $textBossMobile;

            $baseurl = "http://www.textit.biz/sendmsg";
            $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
            $ret = file($url);

            $res = explode(":", $ret[0]);

            if (trim($res[0]) == "OK") {
                echo "Message Sent - ID : " . $res[1];
            } else {
                echo "Sent Failed - Error : " . $res[1];
            }
        }


        return redirect()->route('payment.index')->with('message', 'new payment saved');
    }

    /**
     * Display the specified resource.
     */
    public function show(Payment $payment)
    {
        $arr['payment'] = $payment;
        $arr['payment_links'] = DB::table('payment_repair_job_links')->where('payment_id', $payment->id)->get();
        $arr['cheques'] = DB::table('cheques')->where('payment_id', $payment->id)->get();

        return view('admin.payment.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Payment $payment)
    {
        $arr['customers'] = Customer::select('id', 'name')->orderBy('name', 'asc')->get();
        $arr['banks'] = Bank::select('id', 'name')->get();
        $arr['payment'] = $payment;
        $arr['cheques'] = DB::table('cheques')->where('payment_id', $payment->id)->get();

        return view('admin.payment.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Payment $payment)
    {
        $validatedData = $request->validate([
            'TotalAmount' => 'required|numeric',
            'customer_name' => 'required',
        ]);
        $customerID = Customer::where('name', $request->customer_name)->value('id');
        if ($payment->method == 'Cheque') {
            $numofCheques = Cheque::where('payment_id', $payment->id)->count('id');
            for ($i = 1; $i < $numofCheques; $i++) {
                $chequeNo = 'chequeNo' . $i;
                $bankNo = 'bankNo' . $i;
                $branchNo = 'branchNo' . $i;
                $chequeAmount = 'chequeAmount' . $i;
                $chequeDate = 'chequeDate' . $i;
                if (
                    $request->$chequeNo != '' ||
                    $request->$bankNo != '' ||
                    $request->$branchNo != '' ||
                    $request->$chequeAmount != '' ||
                    $request->$chequeDate != ''
                ) {
                    $validatedData = $request->validate([
                        $chequeNo => 'required|numeric',
                        $bankNo => 'required|numeric',
                        $branchNo => 'required|numeric',
                        $chequeAmount => 'required|numeric',
                        $chequeDate => 'required',
                    ]);
                }
            }
        }

        if ($request->Method == 'Cheque') {
            $deleted = DB::table('cheques')->where('payment_id', $payment->id)->delete();
            for ($j = 1; $j <= $numofCheques; $j++) {
                $chequeNo = 'chequeNo' . $j;
                $bankNo = 'bankNo' . $j;
                $branchNo = 'branchNo' . $j;
                $chequeAmount = 'chequeAmount' . $j;
                $chequeDate = 'chequeDate' . $j;

                if ($request->$chequeNo != '') {
                    $cheque = new Cheque();
                    $cheque->payment_id = $payment->id;
                    $cheque->cheque_number = $request->$chequeNo;
                    $cheque->cheque_bank = $request->$bankNo;
                    $cheque->cheque_branch = $request->$branchNo;
                    $cheque->amount = $request->$chequeAmount;
                    $cheque->cheque_date = $request->$chequeDate;
                    $cheque->customer_id = $customerID;
                    $cheque->status = 'pending';
                    $cheque->balance = $request->$chequeAmount;
                    $cheque->save();
                }
            }
        }

        $payment->amount = $request->TotalAmount;
        $payment->allocated_to_job = 0;
        $payment->balance_to_allocate = $request->TotalAmount;
        $payment->customer_id = $customerID;
        if ($request->Method == 'BankTransfer') {
            $payment->bank_id = $request->bank;
        }
        $payment->save();
        return redirect()->route('payment.index')->with('message', 'Payment Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Payment $payment)
    {
        if ($payment->status == 'with sales') {
            if ($payment->method == 'Cheque') {
                $deleted = DB::table('cheques')->where('payment_id', $payment->id)->delete();
            }

            $payment->delete();
        }

        return redirect()->route('payment.index');
    }
}
