<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Courier\CourierCustomer;
use App\Models\CourierPickup;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\PDF;

class CourierPickupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $arr['Courierpickups'] = CourierPickup::orderBy('id', 'desc')->get();
        return view('admin.pickup.index')->with($arr);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $arr['CourierCustomers'] = Customer::orderBy('id', 'desc')->get();
        return view('admin.pickup.create')->with($arr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, CourierPickup $courierPickup)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|string',
        ]);
        if (DB::table('customers')
            ->where('name', $request->customer_name)
            ->doesntExist()
        ) {
            return redirect()->route('courier_pickup.create')
                ->with('error', 'customer selected not available in the system,
            create courier customer before scheduling a pickup!');
        }

        $customer = DB::table('customers')
            ->where('name', $request->customer_name)
            ->first();
        $courierPickup->customer_id = $customer->id;
        $courierPickup->status = 'pending';
        $courierPickup->save();

        // send email to prompt
        $CN = $customer->name;
        $CA = $customer->address;
        $CM = $customer->land_phone;
        $mobile = $customer->mobile;

        $to = "customercare@promptxpress.lk";
        //$to = "retoplanka@gmail.com";
        $subject = "Repair Pick up ";
        $msg = "Repair machine to pick up \n FROM \n CUSTOMER NAME - " . $CN .
            " \n CUSTOMER ADDRESS - " . $CA . " \n CUSTOMER TEL - " . $CM . " \n CUSTOMER Mobile - " . $mobile .
            "\n\n TO \n K & K International Lanka Pvt Ltd \n No 9, 5th lane, Borupana Road, \n Ratmalana \n 0777696922 ";

        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg, 70);

        $headers = "From: info@kandkinter.com" . "\r\n" .
            "CC: retoprepair@gmail.com, info@weld.lk";

        // send email
        mail($to, $subject, $msg, $headers);

        return redirect()->route('CourierPickup.index')->with('message', 'Pickup was Created!');
    }

    /**
     * Display the specified resource.
     */
    public function show(CourierPickup $courierPickupID)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($courierPickupID)
    {
        $courierPickup = CourierPickup::where('id', $courierPickupID)->first();
        $customer = DB::table('customers')
            ->where('id', $courierPickup->customer_id)
            ->first();

        $CN = $customer->name;
        $CA = $customer->address;
        $CM = $customer->land_phone;
        $mobile = $customer->mobile;

        $to = "customercare@promptxpress.lk";
        //$to = "retoplanka@gmail.com";
        $subject = "Repair Pick up ";

        $msg = "Repair machine to pick up not Picked up yet. THIS IS A KIND REMINDER TO PICKUP ASAP!! \n FROM \n CUSTOMER NAME - " . $CN .
            " \n CUSTOMER ADDRESS - " . $CA . " \n CUSTOMER TEL - " . $CM . " \n CUSTOMER Mobile - " . $mobile .
            "\n\n TO \n K & K International Lanka Pvt Ltd \n No 9, 5th lane, Borupana Road, \n Ratmalana \n 0777696922 ";

        // use wordwrap() if lines are longer than 70 characters
        $msg = wordwrap($msg, 70);

        $headers = "From: info@kandkinter.com" . "\r\n" .
            "CC: retoprepair@gmail.com, info@weld.lk, ruwanp@promptxpress.lk";

        // send email
        mail($to, $subject, $msg, $headers);

        $arr['Courierpickups'] = CourierPickup::orderBy('id', 'desc')->get();
        return view('admin.pickup.index')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $cou = CourierPickup::where('id', $request->COPICKID)->first();
        $cou->status = "Received";
        $cou->save();
        return redirect()->route('courier_pickup.index')->with('message', 'Pickup was Received!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CourierPickupController $courierPickupController)
    {
        //
    }
}
