<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserStatusRequest;
use App\Http\Requests\Admin\UpdateUserStatusRequest;
use App\Http\Resources\Api\V1\UserStatusResource;
use App\Models\UserStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;

class UserStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): AnonymousResourceCollection
    {
        return UserStatusResource::collection(UserStatus::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserStatusRequest $request): JsonResponse
    {
        UserStatus::create($request->validated());

        return response()->json(['message' => 'Ктаегория успешно добавлена']);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): JsonResponse
    {
        $userStatus = UserStatus::find($id);
        if (!$userStatus) {
            return response()->json(['message' => 'Статус не найден', 404]);
        }

        return response()->json(['data' => new UserStatusResource($userStatus)]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserStatusRequest $request, UserStatus $userStatus): JsonResponse
    {
        $userStatus->update($request->validated());

        return response()->json(['message' => 'Имя статуса изменено на ' .$userStatus->name]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserStatus $userStatus): JsonResponse
    {
        $userStatus->delete();

        return response()->json(['message' => $userStatus->name . ' удален']);
    }
}
