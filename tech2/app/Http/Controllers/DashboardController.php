<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $now = Carbon::now();
        $this_month = $now->month;
        $this_year = $now->year;

        $data = DB::table('repair_job_status_details')
        ->join('users', 'repair_job_status_details.user_id', '=', 'users.id')
        ->select(DB::raw('users.name as user_name, repair_job_status_details.user_id, count(repair_job_status_details.id) as count_id, MONTH(repair_job_status_details.created_at) as month, YEAR(repair_job_status_details.created_at) as year'))
        ->groupby(DB::raw('users.name, repair_job_status_details.user_id, YEAR(repair_job_status_details.created_at) ASC, MONTH(repair_job_status_details.created_at) ASC'))
        ->where('repair_job_status_details.repair_job_status_id', 4)
        ->whereMonth('repair_job_status_details.created_at', $this_month)
        ->whereYear('repair_job_status_details.created_at', $this_year)
        ->orderBy('count_id', 'desc')
        ->get()->toArray();

        // dd($data);
        $x_axis = [];
        $y_axis = [];

        foreach ($data as $item){
            array_push($x_axis, $item->user_name);
            array_push($y_axis, $item->count_id);
        }
        return view('dashboard', [
            'x_axis' => $x_axis,
            'y_axis' => $y_axis,
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
