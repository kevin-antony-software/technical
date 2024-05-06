<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Bank extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'balance'];

    /**
     * Get all of the comments for the Bank
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bankDetails(): HasMany
    {
        return $this->hasMany(BankDetail::class);
    }
}
