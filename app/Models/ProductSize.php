<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductSize extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'size_name',
        'size_value',
        'unit',
        'price_adjustment',
    ];


    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

}
