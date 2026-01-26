<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CartStatus extends Model
{
    /** @use HasFactory<\Database\Factories\CartStatusFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];
    protected function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
}
