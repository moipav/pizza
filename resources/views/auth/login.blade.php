@extends('layout')

@section('title', 'Добро пожаловать')
@section('content')
    <form method="POST" action="{{route('login')}}">
        @csrf
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow border-0 rounded-3">
                        <div class="card-body p-4">
                            <h3 class="text-center mb-4">Войти</h3>
{{--                            <form>--}}
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
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="true" id="flexCheckDefault" name="remember">
                                    <label class="form-check-label" for="flexCheckDefault">
                                        Запомнить меня
                                    </label>
                                </div>
                                <!-- Кнопка -->
                                <button type="submit" class="btn btn-primary w-100 py-2">Войти</button>

                                <div class="text-center mt-3">
                                    <small class="text-muted">Нет аккаунта? <a href="{{route('register')}}">Регистрация</a></small>
                                </div>
{{--                            </form>--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
