@extends('layout')

@section('content')
    <h1>Продукты </h1>
    <a href="{{ route('product-sizes.create') }}" class="btn btn-primary">Добавить размер</a>

    <table class="table">
        <thead>
        <tr>
            <th>Продукт</th>
            <th>Вид продукта</th>
            <th>Наименование</th>
            <th>Размер(объем)</th>
            <th>Единицы измерения</th>
            <th>Добавленная стоимость</th>
        </tr>
        </thead>
        <tbody>

            <tr>
                <td>
                    @if ($productSize->product->name)
                        {{ $productSize->product->name }}
                    @else
                        <b>Продукт отсутствует, возможно он удален</b>
                    @endif
                </td>  <td>
                    @if ($productSize->product->category->name)
                        {{ $productSize->product->category->name }}
                    @else
                        <b>Категория продукта отсутствует, возможно она удалена</b>
                    @endif
                </td>
                <td>{{ $productSize->size_name }}</td>
                <td>{{ $productSize->size_value }}</td>
                <td>{{ $productSize->unit }}</td>
                <td>{{ $productSize->price_adjustment}}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('product-sizes.show', $productSize) }}">Просмотр</a>
                    <a class="btn btn-warning" href="{{ route('product-sizes.edit', $productSize) }}">Редактировать</a>
                    <form action="{{ route('product-sizes.destroy', $productSize) }}" method="POST"
                          style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit" onclick="return confirm('Удалить?')">Удалить
                        </button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
@endsection
