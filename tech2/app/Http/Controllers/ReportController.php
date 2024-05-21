<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\RepairJob;
use App\Models\RepairJobStatusDetail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function closed_jobs()
    {

        return view('admin.report.closed_jobs', [
            'data1' => RepairJobStatusDetail::where('repair_job_status_id', '=', 4)->get(),

        ]);
    }

    public function today_closed_jobs()
    {
        return view('admin.report.today_closed_jobs', [
            'data1' => RepairJobStatusDetail::where('repair_job_status_id', '=', 4)
                ->whereDate('created_at', Carbon::today())
                ->get(),

        ]);
    }

    public function outstanding()
    {
        return view('admin.report.outstanding', [
            'repair_jobs' => RepairJob::where('due_amount', '>', 20)->get(),

        ]);
    }


    public function closed_summary()
    {

        $data = DB::table('repair_job_status_details')
            ->join('users', 'repair_job_status_details.user_id', '=', 'users.id')
            ->select(DB::raw('users.name as user_name, repair_job_status_details.user_id, count(repair_job_status_details.id) as count_id, MONTH(repair_job_status_details.created_at) as month, YEAR(repair_job_status_details.created_at) as year'))
            ->groupby(DB::raw('users.name, repair_job_status_details.user_id, YEAR(repair_job_status_details.created_at) ASC, MONTH(repair_job_status_details.created_at) ASC'))
            ->where('repair_job_status_details.repair_job_status_id', 4)
            ->get()->toArray();

        return view('admin.report.closed_summary', [

            'data' => $data,

        ]);
    }
}
