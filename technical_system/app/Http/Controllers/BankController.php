<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Http\Controllers\Controller;
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
        Bank::create($data);
        return redirect()->route('bank.index')->with('message', 'New Bank saved!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bank $bank)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bank $bank)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bank $bank)
    {
        //
    }
}
