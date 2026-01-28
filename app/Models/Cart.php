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


    public static function current(): self
    {
        if (auth()->check()) {
            //авторизованный пользователь - ищем по user_id

            return static::firstOrCreate(
                ['user_id' => auth()->id(), 'status_id' => 1], // active
                ['session_id' => null]
            );
        }
        //гость - используем session_id
        $sessionId = Session::getId();

        return static::firstOrCreate(
            ['session_id' => $sessionId, 'status_id' => 1],
            ['user_id' => null]
        );
    }

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function status(): BelongsTo
    {
        return $this->belongsTo(CartStatus::class, 'status_id');
    }

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
