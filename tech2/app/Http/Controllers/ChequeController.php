<?php

namespace App\Http\Controllers;

use App\Models\Cheque;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankDetail;
use App\Models\Customer;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ChequeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $arr['cheques'] = Cheque::All();
        $arr['banks'] = Bank::select('id', 'name')->get();
        return view('admin.cheque.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Cheque $cheque)
    {
        //
    }
    public function passCheque(Request $request, Cheque $cheque)
    {
        if ($request->bankID == "") {
            return redirect()->route('cheque.index')->with('error', 'need to select a bank');
        }
        $payment = Payment::where('id', $cheque->payment_id)->first();
        if ($payment->status == 'with sales') {
            return redirect()->route('cheque.index')->with('error', 'cheque need to be with accounts');
        }
        DB::table('banks')->where('id', $request->bankID)->increment('balance', $cheque->amount);
        $bankDetails = new BankDetail();
        $bankDetails->bank_id = $request->bankID;
        $bankDetails->payment_id = $payment->id;
        $bankDetails->amount = $cheque->amount;
        $bankDetails->credit_amount = $cheque->amount;
        $bankDetails->bank_balance = DB::table('banks')->where('id', $request->bankID)->value('balance');
        $bankDetails->reason = 'cheque passed - ' . $cheque->number . " - cus - " . $payment->customer_name;
        $bankDetails->save();
        $cheque->status = 'passed';
        $cheque->save();
        return redirect()->route('cheque.index');
    }

    public function returnCheque(Cheque $cheque)
    {
        $cheque->status = 'returned';
        $cheque->save();
        return redirect()->route('cheque.index');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cheque $cheque)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $arr['cheque'] = Cheque::where('id', $cheque->id)->first();
        return view('admin.cheque.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cheque $cheque)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $validatedData = $request->validate([
            'NewChequeNo' => 'numeric',
            'NewBranchNo' => 'numeric',
            'NewBankNo' => 'numeric',
            'newChequeDate' => 'date',
        ]);
        $cheque->cheque_date = $request->newChequeDate;
        $cheque->cheque_number = $request->NewChequeNo;
        $cheque->cheque_bank = $request->NewBankNo;
        $cheque->cheque_branch = $request->NewBranchNo;
        $cheque->save();

        return redirect()->route('cheque.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cheque $cheque)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('home');
        }
        $cheque->delete();
        return redirect()->route('cheque.index');
    }
}
