<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static insert(array $array)
 */
class Role extends Model
{
    protected $fillable = ['name'];

    public function users(): HasMany
    {
        return $this->HasMany(User::class, 'role_id');
    }
}
