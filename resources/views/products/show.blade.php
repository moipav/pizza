@extends('layout')

@section('content')
    <h1>Продукты </h1>
    <a href="{{ route('products.create') }}" class="btn btn-primary">Добавить новый продукт</a>

    <table class="table">
        <thead>
        <tr>
            <th>Изображение</th>
            <th>Название</th>
            <th>Описание</th>
            <th>Размер</th>
            <th>Стоимость</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $product->image }}</td>
                <td>{{ $product->name }}</td>
                <td>{{$product->description}}</td>
                <td>Здесь будут размеры</td>
                <td>{{$product->price}}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('product.show', $product) }}">Просмотр</a>
                    <a class="btn btn-warning" href="{{ route('product.edit', $product) }}">Редактировать</a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit" onclick="return confirm('Удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
