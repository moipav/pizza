@extends('layout')

@section('content')
    <h1>Возможные размеры для товаров</h1>
    <a href="{{ route('product-sizes.create') }}" class="btn btn-primary">Добавить размер</a>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Категория</th>
        </tr>
        </thead>
        <tbody>
        @foreach($productSizes as $productSize)
            <tr>
                <td>{{ $productSize->id }}</td>
                <td>{{ $productSize->name }}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('categories.show', $productSize) }}">Просмотр</a>
                    <a class="btn btn-warning" href="{{ route('categories.edit', $productSize) }}">Редактировать</a>
                    <form action="{{ route('categories.destroy', $productSize) }}" method="POST" style="display:inline;">
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
