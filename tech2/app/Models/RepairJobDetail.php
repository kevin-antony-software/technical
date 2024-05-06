<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RepairJobDetail extends Model
{
    use HasFactory;
    public function repair_job()
    {
        return $this->belongsTo(RepairJob::class);
    }
    public function component() {
        return $this->belongsTo(Component::class);
    }


}
