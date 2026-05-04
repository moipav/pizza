<?php declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CartStatus extends Model
{

    protected $fillable = [
        'name',
    ];
    protected function cart(): HasMany
    {
        return $this->hasMany(Cart::class);
    }
}
