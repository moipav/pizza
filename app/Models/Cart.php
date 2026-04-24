<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Session;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
        'session_id',
        'status_id',
    ];

//вынести в отдельный сервис


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function status(): BelongsTo
    {
        return $this->belongsTo(CartStatus::class, 'status_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
