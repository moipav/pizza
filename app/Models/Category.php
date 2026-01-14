<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    protected $fillable = ['name'];
/*
 * TODO подумаем насчет timestamps
 */
    public $timestamps = false;
    protected function products(): HasMany
    {
        return $this->hasMany(Product::class);//одна категория содержит много продуктов
    }
}
