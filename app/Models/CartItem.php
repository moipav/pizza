<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id',
        'product_id',
        'product_size_id',
        'quantity',
        'price_per_unit',
    ];

    /**
     * @return string[]
     * приводим к нужному типу данных
     */
    protected function casts(): array
    {

        return [
            'quantity' => 'integer',
            'price_per_unit' => 'decimal:2'
        ];
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function productSize(): BelongsTo
    {
        return $this->belongsTo(ProductSize::class, 'product_size_id');
    }


//    public function getProductAttribute()
//    {
//        return $this->productSize()->product();
//    }
}
