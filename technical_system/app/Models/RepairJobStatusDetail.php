<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairJobStatusDetail extends Model
{
    use HasFactory;

    public function status() {
        return $this->belongsTo(RepairJobStatus::class, 'repair_job_status_id');
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}
