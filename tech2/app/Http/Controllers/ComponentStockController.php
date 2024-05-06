<?php

namespace App\Http\Controllers;

use App\Models\ComponentStock;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComponentStockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.component_stock.index', [
            'component_stocks' => ComponentStock::all(),
        ]);
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
    public function show(ComponentStock $componentStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComponentStock $componentStock)
    {
        return view('admin.component_stock.edit', [
            'component_stock' => $componentStock,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComponentStock $componentStock)
    {
        $data = $request->validate([
            'new_qty' => 'required|numeric',
        ]);

        $componentStock->qty = $request->new_qty;
        $componentStock->save();
        return to_route('component_stock.index')->with('message', 'component stock updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComponentStock $componentStock)
    {
        $componentStock->delete();
        return to_route('component_stock.index')->with('message', 'component stock was deleted');
    }
}
