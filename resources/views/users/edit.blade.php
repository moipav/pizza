@extends('layout')

@section('content')
    <h1>Редактировать пользователя {{$user->name}}</h1>

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Имя:</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $user->name) }}"
                   required>
        </div>
        <div>
            <div>
                <label for="surname">Фамилия:</label>
                <input type="text" class="form-control" name="surname" id="surname"
                       value="{{ old('name', $user->surname) }}" required>
            </div>
            <div>
                <label for="phone">Номер телефона (без +7):</label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $user->phone) }}"
                       required>
            </div>
            <label for="email">Email:</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $user->email) }}"
                   required>
        </div>
        <div>
            <label for="date_of_birth">День рождения:</label>
            <input type="date" class="form-control" name="date_of_birth" id="date_of_birth"
                   value="{{old('date_of_birth', $user->date_of_birth)}}" required>
        </div>
        <div>
            <button type="submit">Обновить</button>
        </div>
        <button type="submit">Обновить</button>
    </form>
@endsection
