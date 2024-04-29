<?php

namespace App\Http\Controllers;

use App\Models\BankDetail;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\PDF;


class BankDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $arr['banks'] = Bank::all();
        return view('admin.bankDetails.create')->with($arr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $validated = $request->validate([
            'FromBankname' => 'required',
            'ToBankname' => 'required',
            'Amount' => 'required|numeric',
        ]);

        $fromBankName = DB::table('banks')->where('id', $request->FromBankname)->value('name');
        $toBankName = DB::table('banks')->where('id', $request->ToBankname)->value('name');
        $available = DB::table('banks')->where('id', $request->FromBankname)->value('balance');

        if ($available < $request->Amount){
            return redirect()->route('bankDetails.create')->with('error', 'balance not enough')->withInput();
        } else {
            DB::table('banks')->where('id', $request->FromBankname)->decrement('balance', $request->Amount);
            DB::table('banks')->where('id', $request->ToBankname)->increment('balance', $request->Amount);
            $fromBank = new BankDetail();
            $fromBank->bank_id = $request->FromBankname;
            $fromBank->amount = $request->Amount;
            $fromBank->debit_amount = $request->Amount;
            $fromBank->bank_balance = $available - $request->Amount;
            $fromBank->reason = "Fund Transfer - " . $toBankName;
            $fromBank->save();
            $toBank = new BankDetail();
            $toBank->bank_id = $request->ToBankname;
            $toBank->amount = $request->Amount;
            $toBank->credit_amount = $request->Amount;
            $toBank->bank_balance = DB::table('banks')->where('id', $request->ToBankname)->value('balance');
            $toBank->reason = "Fund Transfered - " . $fromBankName;
            $toBank->save();
        }
        return redirect()->route('bank.index')->with('message', 'Bank Transfer Done!');
    }

    /**
     * Display the specified resource.
     */
    public function show(BankDetail $bankDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BankDetail $bankDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BankDetail $bankDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BankDetail $bankDetail)
    {
        //
    }
}
