@extends('layout')

@section('content')
    <h1>{{$user->name}} {{$user->surname}}</h1>

    <p>e-mail: <b>{{$user->email}}</b></p>
    <p>Номер телефона: <b>+7{{$user->phone}}</b></p>
    <p>Дата регистрации: <b>{{$user->created_at}}</b></p>

    <a class="btn btn-primary" href="{{ route('users.index') }}">Список пользователей</a>
@endsection
