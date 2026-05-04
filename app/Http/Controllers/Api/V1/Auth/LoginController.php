<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Actions\Auth\LoginUser;
use App\Actions\Cart\MergeCartWithLogin;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Js;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct(
        private readonly LoginUser $loginUser,
        private readonly MergeCartWithLogin $mergeCartWithLogin
    )
    {

    }

    public function login(Request $httpRequest, LoginRequest $request): JsonResponse
    {
        $result = $this->loginUser->execute($request);

        $guestToken = $httpRequest->header('X-Guest-Token');
        if ($guestToken && isset($result['user'])) {
            $this->mergeCartWithLogin->execute($result['user']->id, $guestToken);
        }
        return response()->json([
            'result' => $result['user'],
            'token' => $result['token'],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Выход выполнен']);

    }
}
