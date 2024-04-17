<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairJobStatus extends Model
{
    use HasFactory;
    public function repair_jobs()
    {
        return $this->hasMany(RepairJob::class);
    }
}
