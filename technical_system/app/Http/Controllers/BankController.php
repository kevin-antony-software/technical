<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Http\Controllers\Controller;
use App\Models\BankDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\PDF;


class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $arr['banks'] = Bank::All();
        return view('admin.bank.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        return view('admin.bank.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $data = $request->validate([
            'name' => 'required|unique:banks,name|max:255',
            'balance' => 'required|numeric',

        ]);
        $bank = Bank::create($data);
        $bankDetail = new BankDetail();
        $bankDetail->bank_id =$bank->id;
        $bankDetail->amount = $request->balance;
        $bankDetail->credit_amount = $request->balance;
        $bankDetail->bank_balance = $request->balance;
        $bankDetail->reason = "bank initiated with - " . $request->balance;
        $bankDetail->save();


        return redirect()->route('bank.index')->with('message', 'New Bank saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $arr['bankDetails'] = BankDetail::where('bank_id', $bank->id)->orderBy('id', 'desc')->paginate(25);
        return view('admin.bank.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $arr['bank'] = $bank;
        return view('admin.bank.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }

        $validatedData = $request->validate([
            'name' => ['required', Rule::unique('banks')->ignore($bank->id)],
            'balance' => 'required|numeric',
        ]);

        $bank->name = $request->name;
        $bank->balance = $request->balance;
        $bank->save();
        return redirect()->route('bank.index')->with('message', 'bank updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        if (Gate::denies('director-only')) {
            return redirect()->route('dashboard');
        }
        $bank->delete();
        return redirect()->route('bank.index');
    }
}
