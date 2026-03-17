@extends('layout')

@section('title', 'Регистрация')
@section('content')
    <form method="POST" action="{{route('register')}}">
        @csrf
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow border-0 rounded-3">
                        <div class="card-body p-4">
                            <h3 class="text-center mb-4">Создать аккаунт</h3>
                            <form>
                                <!-- Имя -->
                                <div class="form-floating mb-3">
                                    <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" placeholder="Имя" required>
                                    <label for="name">Имя</label>
                                </div>

                                <!-- Email -->
                                <div class="form-floating mb-3">
                                    <input type="email" class="form-control" id="email" name="email" value="{{old('email')}}" placeholder="name@example.com" required>
                                    <label for="email">Email адрес</label>
                                </div>

                                <!-- Пароль -->
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Пароль">
                                    <label for="password">Пароль</label>
                                </div>
                                <div class="form-floating mb-3">
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Пароль">
                                    <label for="password">Пароль</label>
                                </div>

                                <!-- Кнопка -->
                                <button type="submit" class="btn btn-primary w-100 py-2">Зарегистрироваться</button>

                                <div class="text-center mt-3">
                                    <small class="text-muted">Уже есть аккаунт? <a href="{{route('login')}}">Войти</a></small>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
