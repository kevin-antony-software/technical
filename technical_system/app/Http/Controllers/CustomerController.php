<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.customer.index', [
            'customers' => Customer::orderBy('id', 'DESC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:customers',
            'address' => 'required|string',
            'mobile' => 'required|numeric',
            'land_phone' => 'numeric|nullable',
            'company' => 'string|nullable',
        ]);
        $customer = Customer::create($data);
        return to_route('customer.index')->with('message', 'new customer added to the system');
    }

    /**
     * Display the specified resource.
     */
    public function show(Customer $customer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Customer $customer)
    {
        return view('admin.customer.edit', [
            'customer' => $customer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Customer $customer)
    {
        $data = $request->validate([
            'name' => ['required', Rule::unique('customers')->ignore($customer->id)],
            'address' => 'required|string',
            'mobile' => 'required|numeric',
            'land_phone' => 'numeric|nullable',
            'company' => 'string|nullable',
        ]);

        $customer->update($data);

        return to_route('customer.index')->with('message', 'Customer was updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Customer $customer)
    {
        $customer->delete();
        return to_route('customer.index')->with('message', 'Customer was deleted');

    }
}
