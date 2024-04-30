<?php

namespace App\Http\Controllers;

use App\Models\Cash;
use App\Http\Controllers\Controller;
use App\Models\Bank;
use App\Models\BankDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CashController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arr['cash'] = Cash::paginate(500);
        return view('admin.cash.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $arr['cashBalance'] = DB::table('cashes')
            ->select('balance')
            ->orderBy('id', 'desc')
            ->value('balance');
        $arr['banks'] = Bank::all();
        return view('admin.cash.create')->with($arr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Bank' => 'required',
            'Amount' => 'required|numeric',
        ]);
        $cashBalance = 0;
        $cashBalance = DB::table('cashes')
            ->select('balance')
            ->orderBy('id', 'desc')
            ->value('balance');

        if ($request->BankAction == "Withdraw") {
            DB::table('banks')->where('id', $request->Bank)->decrement('balance', $request->Amount);
            $bankDetail = new BankDetail();
            $bankDetail->bank_id = $request->Bank;
            $bankDetail->amount = $request->Amount;
            $bankDetail->debit_amount = $request->Amount;
            $bankDetail->bank_balance = DB::table('banks')->where('id', $request->Bank)->value('balance');
            $bankDetail->reason = 'Cash Withdrawal';
            $bankDetail->save();

            DB::table('cashes')->insert([
                'amount' => $request->Amount,
                'category' => 'withdrawal from Bank',
                'balance' => $cashBalance + $request->Amount,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        } elseif ($request->BankAction == "deposite") {
            DB::table('banks')->where('id', $request->Bank)->increment('balance', $request->Amount);
            $bankDetail = new BankDetail();
            $bankDetail->bank_id = $request->Bank;
            $bankDetail->amount = $request->Amount;
            $bankDetail->credit_amount = $request->Amount;
            $bankDetail->bank_balance = DB::table('banks')->where('id', $request->Bank)->value('balance');
            $bankDetail->reason = 'Cash Deposite';
            $bankDetail->save();

            DB::table('cashes')->insert([
                'amount' => $request->Amount,
                'category' => 'Deposite to the Bank',
                'balance' => $cashBalance - $request->Amount,
                'created_at' =>  \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
        return redirect()->route('cash.index')->with('message', 'Cash and Banks are Updated');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cash $cash)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cash $cash)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $arr['cash'] = $cash;
        return view('admin.cash.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cash $cash)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $validatedData = $request->validate([
            'newCash' => 'required|numeric',
        ]);

        $amount = $request->newCash - $cash->balance;
        $cashNew = New Cash();
        $cashNew->amount = $amount;
        $cashNew->category = "Cash adjustment";
        $cashNew->balance = $request->newCash;
        $cashNew->save();
        return redirect()->route('cash.index')->with('message', 'Cash Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cash $cash)
    {
        //
    }
}
