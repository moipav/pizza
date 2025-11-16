@extends('layout')

@section('content')
<h1>Пользователи</h1>
<a href="{{ route('users.create') }}" class="btn btn-primary">Добавить пользователя</a>

{{--@if(session('success'))--}}
{{--    <div class="alert alert-success">{{ session('success') }}</div>--}}
{{--@endif--}}

<table class="table">
    <thead>
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Действия</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                <a class="btn btn-primary" href="{{ route('users.show', $user) }}">Просмотр</a>
                <a class="btn btn-warning" href="{{ route('users.edit', $user) }}">Редактировать</a>
                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger" type="submit" onclick="return confirm('Удалить?')">Удалить</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
