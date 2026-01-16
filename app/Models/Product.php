<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image'
    ];

    protected function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id');// т.к. у одного продукта одна категория
    }
}
