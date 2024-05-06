<?php

namespace App\Http\Controllers;

use App\Models\CourierWeightPrice;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourierWeightPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.courier_weight_charges.index', [

            'courier_weight_charges' => CourierWeightPrice::orderBy('weight', 'ASC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
    public function show(CourierWeightPrice $courierWeightPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        return view('admin.courier_weight_charges.edit', [

            'courier_weight_charge' => CourierWeightPrice::where('id', $id)->first(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $affected = DB::table('courier_weight_prices')
            ->where('id', $id)
            ->update(['courier_charges' => $request->courier_charges]);

        return to_route('courier_weight_charge.index')->with('message', 'courier weight charge was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        CourierWeightPrice::where('id', $id)->delete();
        return to_route('courier_weight_charge.index')->with('message', 'courier weight charge was deleted');
    }
}
