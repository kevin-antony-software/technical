<?php

namespace App\Http\Controllers;

use App\Models\RepairJob;
use App\Http\Controllers\Controller;
use App\Models\CommonIssue;
use App\Models\Component;
use App\Models\Customer;
use App\Models\MachineModel;
use App\Models\RepairJobDetail;
use App\Models\RepairJobStatus;
use App\Models\RepairJobStatusDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
// use Barryvdh\DomPDF\Facade\PDF;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

use Spatie\MediaLibrary\Conversions\Manipulations;

class RepairJobController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function find()
    {
        return view('admin.repair_job.find', [
            'customers' => Customer::select('name')->get(),
            'machine_models' => MachineModel::select('name')->get(),
        ]);
    }

    public function show_find(Request $request)
    {
        if ($request->job_id == ""){
            $customer = $request->customer_name;
            $model = $request->model;
            if($customer != "" && $model !=""){
                $customer_id = Customer::where('name', $customer)->value('id');
                $model_id = MachineModel::where('name', $model)->value('id');
                $repair_jobs = RepairJob::orderBy('id', 'DESC')->where('customer_id', $customer_id)->where('machine_model_id', $model_id)->get();
            } else if($customer == "") {
                $model_id = MachineModel::where('name', $model)->value('id');
                $repair_jobs = RepairJob::orderBy('id', 'DESC')->where('machine_model_id', $model_id)->get();
            } else{
                $customer_id = Customer::where('name', $customer)->value('id');
                $repair_jobs = RepairJob::orderBy('id', 'DESC')->where('customer_id', $customer_id)->get();
            }
            return view('admin.repair_job.show_find',[
                'customers' => Customer::select('name')->get(),
                'machine_models' => MachineModel::select('name')->get(),
                'repair_jobs' => $repair_jobs,
            ]);
        } else {
            return view('admin.repair_job.show_find',[
                'customers' => Customer::select('name')->get(),
                'machine_models' => MachineModel::select('name')->get(),
                'repair_jobs' => RepairJob::orderBy('id', 'DESC')->where('id', $request->job_id)->get(),
            ]);
        }

    }

    public function printDetail($id)
    {
        $job = RepairJob::where('id', $id)->first();
        $arr['jobDetails'] = RepairJobDetail::where('repair_job_id', $id)->get();
        $arr['job'] = $job;
        $arr['customer'] = Customer::where('id', $job->customer_id)->first();
        $pdf = PDF::loadView('admin.repair_job.printDetail', $arr);
        return $pdf->download('Repair_invoice.pdf');
    }

    public function print($id)
    {
        $job = RepairJob::where('id', $id)->first();
        $arr['job'] = $job;
        $arr['customer'] = Customer::where('id', $job->customer_id)->first();
        $pdf = PDF::loadView('admin.repair_job.print', $arr);
        return $pdf->download('Repair_invoice.pdf');
    }

    public function start($id)
    {
        $repairJob = RepairJob::where('id', $id)->first();
        $repairJob->current_status_id = 2;
        $job_status = new RepairJobStatusDetail();
        $job_status->repair_job_id = $repairJob->id;
        $job_status->repair_job_status_id = 2;
        $job_status->user_id = auth()->user()->id;
        $job_status->save();

        $customer = Customer::where('id', $repairJob->customer_id)->first();
        if ($customer->customer_type == 'end-customer') {
            $textMessage = $customer->customer_name . ", Repair Job Started for welding machine with job id " . $repairJob->id;
            $textBossMobile = $customer->mobile;
            $this->sendSMS($textMessage, $textBossMobile);
        }
        $repairJob->save();
        return redirect()->route('repair_job.index');
    }

    public function estimate($id)
    {
        $repairJob = RepairJob::where('id', $id)->first();
        $arr['job'] = $repairJob;
        $arr['jobDetails'] = RepairJobDetail::where('repair_job_id', $repairJob->id)->get();
        $arr['components'] = Component::orderBy('name', 'desc')->get();
        $arr['issues'] = CommonIssue::all();
        return view('admin.repair_job.estimated')->with($arr);
    }

    public function estimateSave($id, Request $request)
    {
        $job = RepairJob::where('id', $id)->first();
        $job->current_status_id = 3;
        $componentCharges = 0;
        //////////////////
        for ($i = 1; $i < 30; $i++) {
            $product_id = "itemNo_" . $i;
            $itemPrice = "itemPrice_" . $i;
            $itemName = "itemName_" . $i;
            $quantity1 = "quantity_" . $i;

            if ($request->$quantity1 != "") {
                $jobDetail = new RepairJobDetail();
                $jobDetail->repair_job_id = $job->id;
                $jobDetail->component_id = $request->$product_id;
                $jobDetail->component_price = $request->$itemPrice;
                $jobDetail->qty = $request->$quantity1;
                $jobDetail->sub_total = $request->$itemPrice * $request->$quantity1;
                $jobDetail->save();
                $componentCharges += $jobDetail->sub_total;
                //modify the inventory
                DB::table('component_stocks')
                    ->where('component_id', $request->$product_id)
                    ->decrement('qty', $request->$quantity1);
            }
        }

        $job->component_charges = $componentCharges;
        $job->repair_charges = $request->repairCharges;
        $job->total_charges = $request->totalCharges;
        $job->discount = $request->discount;
        $job->final_total = $request->finalTotal - $job->special_discount;
        $job->estimated_cost = $request->finalTotal;

        if ($request->commonIssue == 'common') {
            $job->issue = $request->issueOld;
        } else {
            $job->issue = $request->issue;
        }

        $job_status = new RepairJobStatusDetail();
        $job_status->repair_job_id = $job->id;
        $job_status->repair_job_status_id = 3;
        $job_status->user_id = auth()->user()->id;
        $job_status->save();
        $job->save();

        if ($job->warranty_type == 'Without-Warranty') {
            $customer = Customer::where('id', $job->customer_id)->first();
            if ($customer->customer_type == 'end-customer') {
                $textMessage = $customer->customer_name . ", Repair Job Estimated for RETOP welding machine with job id " . $job->id . "cost of Rs " . $request->finalTotal . "/=";
                $textBossMobile = $customer->mobile;
                $this->sendSMS($textMessage, $textBossMobile);
            }
        }
        return redirect()->route('repair_job.index');
    }

    public function close($id)
    {
        $repairJob = RepairJob::where('id', $id)->first();
        $arr['job'] = $repairJob;
        $arr['jobDetails'] = RepairJobDetail::where('repair_job_id', $repairJob->id)->get();
        $arr['count'] = count($arr['jobDetails']);
        $arr['components'] = Component::orderBy('name', 'desc')->get();
        $arr['issues'] = CommonIssue::all();
        return view('admin.repair_job.closeJob')->with($arr);
    }

    public function closeSave($id, Request $request)
    {
        $job = RepairJob::where('id', $id)->first();
        if ($job->current_status_id == 3) {
            $estimated_component_list = RepairJobDetail::where('repair_job_id', $job->id)->get();
            foreach ($estimated_component_list as $item) {
                DB::table('component_stocks')
                    ->where('component_id', $item->component_id)
                    ->increment('qty', $item->qty);
            }
            $deleted = RepairJobDetail::where('repair_job_id', $job->id)->delete();
        }

        $job->current_status_id = 4;
        $componentCharges = 0;

        for ($i = 1; $i < 30; $i++) {
            $product_id = "itemNo_" . $i;
            $itemPrice = "itemPrice_" . $i;
            $itemName = "itemName_" . $i;
            $quantity1 = "quantity_" . $i;

            if ($request->$quantity1 != "") {
                $jobDetail = new RepairJobDetail();
                $jobDetail->repair_job_id = $job->id;
                $jobDetail->component_id = $request->$product_id;
                $jobDetail->component_price = $request->$itemPrice;
                $jobDetail->qty = $request->$quantity1;
                $jobDetail->sub_total = $request->$itemPrice * $request->$quantity1;
                $jobDetail->save();
                $componentCharges += $jobDetail->sub_total;
                //modify the inventory
                DB::table('component_stocks')
                    ->where('component_id', $request->$product_id)
                    ->decrement('qty', $request->$quantity1);
            }
        }

        $job->component_charges = $componentCharges;
        $job->repair_charges = $request->repairCharges;
        $job->total_charges = $request->totalCharges;
        $job->discount = $request->discount;
        $job->final_total = $request->finalTotal - $job->special_discount;

        if ($request->commonIssue == 'common') {
            $job->issue = $request->issueOld;
        } else {
            $job->issue = $request->issue;
        }

        $customer = Customer::where('id', $job->customer_id)->first();
        if ($job->warranty_type == 'Without-Warranty') {
            $job->due_amount = $request->finalTotal;
            if ($customer->customer_type == 'end-customer') {

                $textMessage = $customer->customer_name . ", Repair Job Closed for RETOP welding machine with job id " . $job->id . "cost of Rs " . $request->finalTotal . "/=";
                $textBossMobile = $customer->mobile;
                $this->sendSMS($textMessage, $textBossMobile);
            }
        } else {
            $job->due_amount = 0;
            if ($customer->customer_type == 'end-customer') {
                $textMessage = $customer->customer_name . ", Repair Job Closed for RETOP welding machine with job id " . $job->id;
                $textBossMobile = $customer->mobile;
                $this->sendSMS($textMessage, $textBossMobile);
            }
        }

        $job_status = new RepairJobStatusDetail();
        $job_status->repair_job_id = $job->id;
        $job_status->repair_job_status_id = 4;
        $job_status->user_id = auth()->user()->id;
        $job_status->save();
        $job->save();

        return redirect()->route('repair_job.index');
    }

    public function deliverPage($id)
    {
        $job = RepairJob::where('id', $id)->first();
        $arr['job'] = $job;
        return view('admin.repair_job.deliver')->with($arr);
    }

    public function deliverSave($id, Request $request)
    {
        // if (Gate::denies('tech-executive-only')) {
        //     return redirect()->route('dashboard');
        // }

        $validatedData = $request->validate([
            'promptOut' => 'required',
            'comment' => 'required',
        ]);

        $job = RepairJob::where('id', $id)->first();
        $job->current_status_id = 5;

        $job_status = new RepairJobStatusDetail();
        $job_status->repair_job_id = $job->id;
        $job_status->repair_job_status_id = 5;
        $job_status->user_id = auth()->user()->id;

        $job->comment = $request->comment;
        $job->method_going_out = $request->promptOut;
        $job_status->save();
        $job->save();

        $customer = Customer::where('id', $job->customer_id)->first();
        if ($customer->customer_type == 'end-customer') {

            $textMessage = $customer->customer_name . ", RETOP Welding machine with Repair Job " . $job->id . " Delivered with " . $job->promptOut;
            $textBossMobile = $customer->mobile;
            $this->sendSMS($textMessage, $textBossMobile);
        }
        return redirect()->route('repair_job.index');
    }

    public function changeWarranty($id)
    {
        $job = RepairJob::where('id', $id)->first();

        if ($job->warranty_type == 'With-Warranty') {
            $job->warranty_type = 'Without-Warranty';
            $job->due_amount = $job->final_total;
            $job->save();
        } else if ($job->warranty_type == 'Without-Warranty') {
            $job->warranty_type = 'With-Warranty';
            $job->due_amount = 0;
            $job->save();
        }

        // return redirect()->route('repair_job.index');
        return redirect()->back();
    }

    public function index()
    {
        return view('admin.repair_job.index', [

            'repair_jobs' => RepairJob::orderBy('id', 'DESC')->paginate(1200),
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
            $textBossMobile = "94743935005";
            $this->sendSMS($textMessage, $textBossMobile);
        } else if ($jobRepairTimes > 1) {
            $textMessage = "this machine with serial " . $request->serial_number . " repair for " . $jobRepairTimes . 'times';;
            $textBossMobile = "94743935005";
            $this->sendSMS($textMessage, $textBossMobile);
            $textMessage = "this machine with serial " . $request->serial_number . " repair for " . $jobRepairTimes . 'times';
            $textBossMobile = "94777770091";
            $this->sendSMS($textMessage, $textBossMobile);
        }

        return to_route('repair_job.index')->with('message', 'Repair Job created');
    }

    private function sendSMS($textMessage, $textBossMobile)
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
    public function uploadImagepage($id)
    {
        $arr['job'] = RepairJob::where('id', $id)->first();
        return view('admin.repair_job.uploadImagesPage')->with($arr);
    }

    public function uploadImageSave($id, Request $request)
    {
        $job = RepairJob::where('id', $id)->first();
        $folder = 'public/repair_images/job_' . $id . '/';

        if ($request->hasFile('image1')) {
            $file = $request->file('image1');
            $extension = $file->getClientOriginalExtension();
            $files =  File::files($folder);
            $nextNum = count($files) + 1;
            $namecreate = "image_" . $id . "_" . $nextNum;
            $finalname = $namecreate . "." . $extension;
            $dest_photo = $folder . $finalname;
            $this->compress_image($file, $dest_photo, 25);
        }

        if ($request->hasFile('image2')) {
            $file = $request->file('image2');
            $extension = $file->getClientOriginalExtension();
            $files =  File::files($folder);
            $nextNum = count($files) + 1;
            $namecreate = "image_" . $id . "_" . $nextNum;
            $finalname = $namecreate . "." . $extension;
            $dest_photo = $folder . $finalname;
            $this->compress_image($file, $dest_photo, 25);
        }

        if ($request->hasFile('image3')) {
            $file = $request->file('image3');
            $extension = $file->getClientOriginalExtension();
            $files =  File::files($folder);
            $nextNum = count($files) + 1;
            $namecreate = "image_" . $id . "_" . $nextNum;
            $finalname = $namecreate . "." . $extension;
            $dest_photo = $folder . $finalname;
            $this->compress_image($file, $dest_photo, 25);
        }

        return redirect()->route('repair_job.index');
    }

    public function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);

        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        elseif ($info['mime'] == 'image/jpg') $image = imagecreatefromjpeg($source_url);

        imagejpeg($image, $destination_url, $quality);

        return $destination_url;
    }
    /**
     * Display the specified resource.
     */
    public function show(RepairJob $repairJob)
    {
        $arr['repair_job'] = $repairJob;
        $arr['components_added'] = RepairJobDetail::where('repair_job_id', $repairJob->id)->get();
        $folder = 'public/repair_images/job_' . $repairJob->id . '/';
        if (File::exists($folder)) {
            $arr['images'] = File::files($folder);
        }



        $arr['repair_job_statuses'] = RepairJobStatusDetail::where('repair_job_id', $repairJob->id)->orderBy('repair_job_status_id', 'asc')->get();

        return view('admin.repair_job.show')->with($arr);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RepairJob $repairJob)
    {
        $arr['models'] = MachineModel::orderBy('name', 'desc')->get();
        $arr['customers'] = Customer::orderBy('name', 'desc')->get();
        $arr['repair_job'] = $repairJob;
        return view('admin.repair_job.edit')->with($arr);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RepairJob $repairJob)
    {
        $validatedData = $request->validate([
            'customer_name' => 'required|exists:customers,name',
            'serial_number' => 'required',
            'model' => 'required|exists:machine_models,name',
            'method_came_in' => 'required',
            'warranty_type' => 'required',
        ]);

        $repairJob->customer_id = Customer::where('name', $request->customer_name)->value('id');
        $repairJob->serial_number = $request->serial_number;
        $repairJob->machine_model_id = MachineModel::where('name', $request->model)->value('id');;
        $repairJob->method_came_in = $request->method_came_in;
        $repairJob->warranty_type = $request->warranty_type;
        $repairJob->special_discount = $request->special_discount;
        if ($repairJob->current_status_id > 2) {
            $repairJob->final_total = $repairJob->final_total - $repairJob->special_discount;
            $repairJob->due_amount = $repairJob->final_total;
        }
        $repairJob->save();
        return to_route('repair_job.index')->with('message', 'Repair Job updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RepairJob $repairJob)
    {
        $repairJob->delete();
        return to_route('repair_job.index')->with('message', 'Repair Job deleted');
    }
}
