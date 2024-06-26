<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;
    public function repair_jobs()
    {
        return $this->hasMany(RepairJob::class);
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function courier_pickups()
    {
        return $this->hasMany(CourierPickup::class);
    }
    protected $fillable = ['customer_type','name', 'address', 'mobile', 'land_phone', 'company'];
}
