<?php

namespace App\Http\Controllers;

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
        $statuses = UserStatus::all();
        return view('users.statuses.index', compact('statuses'));
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

        return redirect()->route('statuses.index')->with('success', 'Статус успешно добавлен');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $userStatus = UserStatus::find($id);
        return view('users.statuses.show', compact('userStatus'));
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
    public function update(Request $request, UserStatus $userStatus): RedirectResponse
    {
        /*
         * TODO Разобраться, почему не меняется имя статуса!
         */
//        dd($request);
        $validated = $request->validate([
            'name' => 'required|string|unique:user_statuses,name,' . $userStatus->id . '|max:255'
        ]);

//        dd($userStatus->update($validated));
        $userStatus->update($validated);

        return to_route('statuses.index', $userStatus)->with('success', 'Данные статуса изменены');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserStatus $userStatus): RedirectResponse
    {
        $userStatus->delete();
        return to_route('users.statuses.index')->with('success', 'Статус удален');
    }
}
