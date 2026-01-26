<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CartItem extends Model
{
    //

    protected function cart():BelongsTo
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    protected function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    protected function productSize(): BelongsTo
    {
        return $this->belongsTo(ProductSize::class, 'product_size_id');
    }
}
