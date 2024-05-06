<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComponentCategory extends Model
{
    use HasFactory;
    public function components()
    {
        return $this->hasMany(Component::class);
    }
    protected $fillable = ['name'];
}
