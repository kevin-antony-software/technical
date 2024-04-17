<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairJob extends Model
{
    use HasFactory;
    public function repair_job_status()
    {
        return $this->belongsTo(RepairJobStatus::class);
    }
}
