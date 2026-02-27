<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\UserStatus;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UserStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {

        return view('users.statuses.index', ['statuses' => UserStatus::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('users.statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:user_statuses'
        ]);

        $userStatus = UserStatus::create($validated);

        return to_route('statuses.index')->with('success', 'Статус успешно добавлен');
    }

    /**
     * Подумаю что сюда прикрутить
     */
    public function show(UserStatus $status): View
    {
        return view('users.statuses.show', ['status' => $status]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $userStatus = UserStatus::find($id);
        return view('users.statuses.edit', compact('userStatus'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserStatus $status): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:user_statuses,name,' . $status->id . '|max:255'
        ]);

        try {
            $status->update($validated);
            return to_route('statuses.index')->with('success', 'Данные статуса изменены');
        } catch (\Exception $e) {
            return to_route('statuses.index', $e)->with('error', 'ощипка');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserStatus $status): RedirectResponse
    {
        $status->delete();
        return to_route('statuses.index')->with('success', 'Статус удален');
    }
}
