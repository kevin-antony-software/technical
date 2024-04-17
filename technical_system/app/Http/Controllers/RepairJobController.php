<?php

namespace App\Http\Controllers;

use App\Models\RepairJob;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RepairJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.repair_job.index', [

            'repair_jobs' => RepairJob::orderBy('id', 'DESC')->get(),
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
    public function show(RepairJob $repairJob)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairJob $repairJob)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RepairJob $repairJob)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairJob $repairJob)
    {
        //
    }
}
