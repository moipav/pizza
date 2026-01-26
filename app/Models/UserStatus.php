<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserStatus extends Model
{
    /*
     * TODO Обеспечить SoftDelete
     */
//    use SoftDeletes;
    protected $fillable = ['name'];

    public $timestamps = false;


    public function users(): HasMany
    {
        return $this->hasMany(User::class); //hasMany — потому что у одного статуса может быть много пользователей.
    }
}
