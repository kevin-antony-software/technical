<?php

namespace App\Http\Controllers;

use App\Models\RepairJob;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\MachineModel;
use App\Models\RepairJobStatus;
use App\Models\RepairJobStatusDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

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
        // if (Gate::denies('tech-executive-only')) {
        //     return redirect()->route('dashboard');
        // }
        $arr['models'] = MachineModel::orderBy('name', 'desc')->get();
        $arr['customers'] = Customer::orderBy('name', 'desc')->get();
        return view('admin.repair_job.create')->with($arr);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|exists:customers,name',
            'serial_number' => 'required',
            'model' => 'required|exists:machine_models,name',
            'method_came_in' => 'required',
            'warranty_type' => 'required',
        ]);

        $idIN = DB::select("SHOW TABLE STATUS LIKE 'repair_jobs'");
        $next_id = $idIN[0]->Auto_increment;

        $folder = 'repair_images/job_' . $next_id;
        if (!File::isDirectory($folder)) {
            File::makeDirectory($folder, 0777, true, true);
        }

        $job = new RepairJob();
        $job->customer_id = Customer::where('name', $request->customer_name)->value('id');
        $job->serial_number = $request->serial_number;
        $job->machine_model_id = MachineModel::where('name', $request->model)->value('id');;
        $job->method_came_in = $request->method_came_in;
        $job->warranty_type = $request->warranty_type;
        $job->current_status_id = 1;
        $jobRepairTimes = DB::table('repair_jobs')->where('serial_number', $request->serial_number)->count();
        $job->repairTimes = $jobRepairTimes;

        $job_status = new RepairJobStatusDetail();
        $job_status->repair_job_id = $next_id;
        $job_status->repair_job_status_id = 1;
        $job_status->user_id = auth()->user()->id;
        $job_status->save();
        $job->save();


        if ($jobRepairTimes == 1) {
            $textMessage = "this machine with serial " . $request->serial_number . " repair for " . $jobRepairTimes . 'times';
            $textBossMobile = "94777770091";
            $this->sensSMS($textMessage, $textBossMobile);
        } else if ($jobRepairTimes > 1) {
            $textMessage = "this machine with serial " . $request->serial_number . " repair for " . $jobRepairTimes . 'times';;
            $textBossMobile = "94777770091";
            $this->sensSMS($textMessage, $textBossMobile);
            $textMessage = "this machine with serial " . $request->serial_number . " repair for " . $jobRepairTimes . 'times';
            $textBossMobile = "94777770091";
            $this->sensSMS($textMessage, $textBossMobile);
        }



        return to_route('repair_job.index')->with('message', 'Repair Job created');
    }

    private function sensSMS($textMessage, $textBossMobile)
    {
        $user = "94777696922";
        $password = "5177";
        $text = urlencode($textMessage);
        $to = $textBossMobile;
        $baseurl = "http://www.textit.biz/sendmsg";
        $url = "$baseurl/?id=$user&pw=$password&to=$to&text=$text";
        $ret = file($url);
        $res = explode(":", $ret[0]);
        if (trim($res[0]) == "OK") {
            echo "Message Sent - ID : " . $res[1];
        } else {
            echo "Sent Failed - Error : " . $res[1];
        }
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
