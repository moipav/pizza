@extends('layout')

@section('content')
    <h1>Добавить новую категорию товара:</h1>
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Категория</label>
            <input type="text" class="form-control" name="name" id="status" value="{{old('category')}}" required>
        </div>
        <button type="submit">Создать</button>
    </form>
@endsection
