@extends('layout')

@section('content')
    <h1>Добавить статус пользователя:</h1>
    <form action="{{ route('statuses.store') }}" method="POST">
        @csrf
        <div>
            <label for="status">Статус</label>
            <input type="text" class="form-control" name="name" id="status" value="{{old('status')}}" required>
        </div>
        <button type="submit">Создать</button>
    </form>
@endsection
