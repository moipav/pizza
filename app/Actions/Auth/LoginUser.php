<?php declare(strict_types=1);

namespace App\Actions\Auth;

use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginUser
{
    public function execute(LoginRequest $request): array
    {
        $credentials = $request->only(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            throw ValidationException::withMessages(['Неверные данные для входа']);
}
        $user = Auth::user();

        return [
            'user' => $user->only(['id', 'name', 'email', 'role']),
            'token' => $user->createToken('auth_token')->plainTextToken,
        ];
    }

}
