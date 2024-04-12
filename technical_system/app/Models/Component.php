<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Component extends Model
{
    use HasFactory;
    public function component_category()
    {
        return $this->belongsTo(ComponentCategory::class);
    }

    public function component_stocks()
    {
        return $this->hasMany(ComponentStock::class);
    }

    protected $fillable = ['name', 'cost', 'price', 'component_category_id'];
}
