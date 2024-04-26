<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class RepairJob extends Model
{
    use HasFactory;




    public function repair_job_status()
    {
        return $this->belongsTo(RepairJobStatus::class, 'current_status_id');
    }
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function machine_model()
    {
        return $this->belongsTo(MachineModel::class);
    }
    public function repair_job_detail()
    {
        return $this->hasMany(RepairJobDetail::class);
    }
}
