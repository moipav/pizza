@extends('layout')

@section('content')
    <h1>Категории товаров</h1>
    <a href="{{ route('categories.create') }}" class="btn btn-primary">Добавить новую категорию товара</a>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Категория</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <td>{{ $category->id }}</td>
                <td>{{ $category->name }}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('categories.show', $category) }}">Просмотр</a>
                    <a class="btn btn-warning" href="{{ route('categories.edit', $category) }}">Редактировать</a>
                    <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
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
