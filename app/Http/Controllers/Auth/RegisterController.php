<?php

namespace App\Http\Controllers\Auth;

use App\Actions\Auth\RegisterUser;
use App\Actions\Cart\MergeCartWithLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct(private readonly MergeCartWithLogin $mergeCartWithLogin)
    {

    }


    public
    function showRegistrationForm()
    {
        return view('auth.register');
    }

    public
    function register(RegisterRequest $request, RegisterUser $registerUser): RedirectResponse
    {
        $result = $registerUser->execute($request->all());
        Auth::login($result); //атоматический вход после регистрации
        $this->mergeCartWithLogin->execute(Auth::id(), $request->cookie('guestID' ?? $request->session()->getId()));
        $request->session()->regenerate();

        return to_route('home')
            ->with('success', 'Вы успешно зарегестрировались, добро пожаловать!')
            ->setStatusCode(201);
    }
}
