<?php

namespace App\Contracts;

use App\Models\Cart;

interface CartResolver
{
    public function resolve(): Cart;
}
