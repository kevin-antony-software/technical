<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
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

    public function today_closed_jobs(){
        return view('admin.report.today_closed_jobs', [
            'data1' => RepairJobStatusDetail::where('repair_job_status_id', '=', 4)->whereDate('created_at', Carbon::today())->get(),

        ]);
    }
}
