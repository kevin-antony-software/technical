<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentPurchaseDetail extends Model
{
    use HasFactory;
    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}
