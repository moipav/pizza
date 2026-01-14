@extends('layout')

@section('content')
    <h1>Редактировать статус пользователя: {{$category->name}}</h1>

    <form action="{{ route('categories.update', $category) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Категория</label>
            <input type="text" class="form-control" name="name" id="name"
                   value="{{ old('name', $category->name) }}" required>
        </div>
        <div>
            <button type="submit">Обновить</button>
        </div>
    </form>
@endsection
