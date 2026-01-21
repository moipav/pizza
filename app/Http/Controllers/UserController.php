<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserController extends Controller
{

    public function index(): View
    {
        return view('users.index', ['users' => User::all()]);
    }


    public function create(): View
    {
        return view('users.create');
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'required|string|unique:users|max:10',
            'email' => 'required|string|email|unique:users|max:255',
            'date_of_birth' => 'required|date|',//before_or_equal:today|after_or_equal:12 years ago',
            'password' => 'required|min:8|confirmed'
        ]);
        $validated['status_id'] = 6;
        User::create($validated);

        return to_route('users.index')->with('success', 'Пользователь добавлен');
    }


    public function show(string $id): View
    {
        $user = User::find($id);

        return view('users.show', compact('user'));
    }

    public function edit(string $id): View
    {
        $user = User::find($id);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'required|string|max:10|unique:users,phone,' . $user->id,
            'email' => 'required|string|email|unique:users,email,' . $user->id . '|max:255',
            'date_of_birth' => 'required|date|' //ограничить дату рождения например не младше 10 лет
        ]);


        $user->update($validated);

        return to_route('users.show', $user)->with('success', 'Данные пользователя обновлены!');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Пользователь удалён!');
    }
}
