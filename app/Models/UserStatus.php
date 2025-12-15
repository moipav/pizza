<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserStatus extends Model
{
    protected $fillable = ['name'];

    public $timestamps = false;
    public function users(): HasMany
    {
        return $this->hasMany(User::class); //hasMany — потому что у одного статуса может быть много пользователей.
    }
}
