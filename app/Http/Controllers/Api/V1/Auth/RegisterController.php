<?php declare(strict_types=1);

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\RegisterUser;
use App\Actions\Cart\MergeCartWithLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use App\Http\Resources\Api\V1\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function __construct(
        private readonly MergeCartWithLogin $mergeCartWithLogin
    ){}

    public function register(Request $httpRequest, RegisterRequest $request, RegisterUser $registerUser): JsonResponse
    {
        $user = $registerUser->execute($request->validated());
        $guestToken = $httpRequest->header('X-Guest-Token');
        if ($guestToken) {
            try {
                $this->mergeCartWithLogin->execute($user->id, $guestToken);
            } catch (\Throwable $e) {
                \Log::error('Не удалось перенести корзину при регистрации', [
                    'user_id' => $user->id,
                    'token' => $guestToken,
                    'error' => $e->getMessage()
                ]);
            }
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(
            [
                'message' => 'Регистрация прошла успешно',
                'token' => $token,
                'user' => new UserResource($user)
            ], 201);
    }
}
