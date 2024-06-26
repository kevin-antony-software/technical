<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineModel extends Model
{
    use HasFactory;

    public function repair_jobs()
    {
        return $this->hasMany(RepairJob::class);
    }
    
    protected $fillable = ['name', 'weight'];
}
