<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\PDF;

class CourierPackingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arr['customers'] = Customer::all();
        return view('admin.packing.create')->with($arr);
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
        for ($x = 1; $x <= 20; $x++) {
            $name = 'customer' . $x;
            $qty = 'Qty' . $x;
            if ($request->$name != "") {
                if (DB::table('customers')->where('name', $request->$name)->doesntExist()) {
                    return redirect()->route('courier_packing.create')->with('error', 'customer doesnt exist')->withInput();
                }
                if ($request->$qty == "") {
                    return redirect()->route('courier_packing.create')->with('error', 'qty cant be empty')->withInput();
                }
            }
        }

        $customerList = array();

        for ($x = 1; $x <= 20; $x++) {
            $name = 'customer' . $x;
            $qty = 'Qty' . $x;
            if ($request->$name != "") {
                $customer = Customer::where('name', $request->$name)->first();

                for ($h = 0; $h < $request->$qty; $h++)
                    array_push($customerList, $customer);
            }
        }
        // dd($customerList);
        $arr['customerList'] = $customerList;
        $pdf = PDF::loadView('admin.packing.print', $arr);
        return $pdf->download('packingList.pdf');
    }

    /**
     * Display the specified resource.
     */
    public function show(CourierPackingController $courierPackingController)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CourierPackingController $courierPackingController)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CourierPackingController $courierPackingController)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourierPackingController $courierPackingController)
    {
        //
    }
}
