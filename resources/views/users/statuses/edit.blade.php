@extends('layout')

@section('content')
    <h1>Редактировать статус пользователя: {{$userStatus->name}}</h1>

    <form action="{{ route('statuses.update', $userStatus) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Статус:</label>
            <input type="text" class="form-control" name="name" id="name"
                   value="{{ old('name', $userStatus->name) }}" required>
        </div>
        <div>
            <button type="submit">Обновить</button>
        </div>
    </form>
@endsection
