<?php

namespace App\Http\Controllers;

use App\Models\ComponentPurchase;
use App\Http\Controllers\Controller;
use App\Models\Component;
use App\Models\ComponentPurchaseDetail;
use App\Models\ComponentStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ComponentPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.component_purchase.index', [

            'component_purchases' => ComponentPurchase::orderBy('id', 'DESC')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.component_purchase.create', [

            'components' => Component::orderBy('name', 'ASC')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        for ($q = 1; $q < 31; $q++) {
            $quantity = "quantity_" . $q;
            $itemNo = "itemNo_" . $q;
            $itemName =  "itemName_" . $q;
            if ($request->$itemNo != "") {
                $validatedData = $request->validate([
                    $quantity => 'required|integer',
                    $itemName => 'required',
                ]);
            }
        }

        $idIN = DB::select("SHOW TABLE STATUS LIKE 'component_purchases'");
        $next_id = $idIN[0]->Auto_increment;

        for ($q = 1; $q < 31; $q++) {
            $quantity = "quantity_" . $q;
            $itemNo = "itemNo_" . $q;
            $itemName =  "itemName_" . $q;

            if ($request->$itemNo != "") {

                $purchaseDetail = new ComponentPurchaseDetail();
                $purchaseDetail->component_id = $request->$itemNo;
                $purchaseDetail->qty = $request->$quantity;
                $purchaseDetail->component_purchase = $next_id;
                $purchaseDetail->save();

                if (DB::table('component_stocks')
                    ->where('component_stocks.component_id', $request->$itemNo)
                    ->exists()
                ) {
                    $affected = DB::table('component_stocks')
                        ->where('component_stocks.component_id', $request->$itemNo)
                        ->increment('qty', $request->$quantity);
                } else {
                    $newStockItem = new ComponentStock();
                    $newStockItem->component_id = $request->$itemNo;
                    $newStockItem->qty = $request->$quantity;
                    $newStockItem->save();
                }
            }
        }

        $ComponentPurchase = new ComponentPurchase();
        $ComponentPurchase->status = "Pending";
        $ComponentPurchase->user_id = Auth::user()->id;
        $ComponentPurchase->save();

        return to_route('component_purchase.index')->with('message', 'component purchase created');
    }

    /**
     * Display the specified resource.
     */
    public function show(ComponentPurchase $componentPurchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ComponentPurchase $componentPurchase)
    {
        return view('admin.component_purchase.edit', [
            'component_purchase' => $componentPurchase,
            'component_pruchase_details' => ComponentPurchaseDetail::where('component_purchase', $componentPurchase->id)->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ComponentPurchase $componentPurchase)
    {
        $componentPurchase->status = "Accepted";
        $componentPurchase->save();
        return to_route('component_purchase.index')->with('message', 'component purchase Accepted');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ComponentPurchase $componentPurchase)
    {
        //
    }
}
