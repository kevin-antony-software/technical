<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentStock extends Model
{
    use HasFactory;
    protected $fillable = ['component_id', 'qty'];

    public function component()
    {
        return $this->belongsTo(Component::class);
    }
}
