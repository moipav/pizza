@extends('layout')

@section('content')
    <h1>Добавить пользователя</h1>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Имя:</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div>
            <label for="surname">Фамилия:</label>
            <input type="text" class="form-control" name="surname" id="surname" required>
        </div>
        <div>
            <label for="phone">Номер телефона (без +7):</label>
            <input type="text" class="form-control" name="phone" id="phone" required>
        </div>
        <div>
            <label for="email">Email:</label>
            <input type="email" class="form-control"name="email" id="email" required>
        </div>
        <div>
            <label for="date_of_birth">День рождения:</label>
            <input type="date" class="form-control" name="date_of_birth" id="date_of_birth" required>
        </div>
        <div>
            <label for="password">Пароль:</label>
            <input type="password" class="form-control" name="password" id="password" required>
        </div>
        <div>
            <label for="password_confirmation">Подтверждение пароля:</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" required>
        </div>
        <button type="submit">Создать</button>
    </form>
@endsection
