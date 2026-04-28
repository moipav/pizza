<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUser;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request, RegisterUser $registerUser)
    {
        $result = $registerUser->execute($request->all());

        Auth::login($result['user']); //атоматический вход после регистрации

        return to_route('home')
            ->with('success', 'Вы успешно зарегестрировались, добро пожаловать!')
            ->setStatusCode(201);
    }
}
