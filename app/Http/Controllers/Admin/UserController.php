<?php
declare(strict_types=1);
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class UserController extends Controller
{

    public function index(): View
    {
        return view('users.index', ['users' => User::with('status')->paginate(300)]);
    }


    public function create(): View
    {
        return view('users.create');
    }


    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::create($request->validated());

        return to_route('users.index')
            ->with('success', 'Пользователь добавлен')
            ->setStatusCode(302);
    }


    public function show(string $id): View
    {
        return view('users.show', ['user' => User::findOrFail($id)]);
    }

    public function edit(string $id): View
    {
        return view('users.edit', ['user' => User::findOrFail($id)]);
    }

    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $user->update($request->validated());

        return to_route('users.show', $user)
            ->with('success', 'Данные пользователя обновлены!')
            ->setStatusCode(302);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return to_route('users.index')
            ->with('success', 'Пользователь удалён!')
            ->setStatusCode(302);
    }
}
