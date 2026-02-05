@extends('layout')

@section('content')
    <h1>Корзина</h1>
    @if($cart->items->isNotEmpty())

        <table class="table">
            <thead>
{{--            <tr>--}}
{{--                <th>Изображение</th>--}}
{{--                <th>Товар</th>--}}
{{--                <th>Размер</th>--}}
{{--                <th>Цена</th>--}}
{{--                <th>количество</th>--}}
{{--                <th>Действия</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
            <tbody>
            @foreach($cart->items as $item)
                <tr>
                    <td><img src="{{\Illuminate\Support\Facades\Storage::url($item->product->image)}}"
                             class="rounded mx-auto d-block" alt="на фото изображено {{$item->product->name}}"
                             width="150"
                             height="150">
                    </td>
                    <td>
                        {{$item->productSize->size_name}}
                    </td>
                    <td>
                        {{$item->productSize->size_value}} {{$item->productSize->unit}}
                    </td>
                    <td>{{$item->price_per_unit}}</td>
                    <td>
                        <form action="{{route('cart.items.update', $item)}}" method="POST" style="display:inline;">
                            @csrf
                            @method('PUT')
                            <label for="quantity"></label>
                            <input type="number" name="quantity" value="{{ $item->quantity }}" min="1" max="999"
                                   style="width: 60px">
                            <button class="btn btn-success" type="submit">Обновить</button>
                        </form>


                        <form action="{{route('cart.items.destroy', $item)}}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" type="submit">Удалить</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
            <tfoot>
            <tr>
                <td colspan="4"><strong>Итого:</strong></td>
                <td>
                    <strong>
                        {{number_format($cart->items->sum(fn($i) => $i->price_per_unit * $i->quantity), 2, ',', ' ') }}
                        Р.
                    </strong>
                </td>
            </tr>
            </tfoot>
        </table>
        {{--        <a href="{{ route('checkout') }}" class="btn btn-success">Оформить заказ</a>--}}
    @else
        <p>Ваша корзина пуста</p>
        <a href="{{ route('home') }}"> Перейти к покупкам</a>
    @endif
@endsection
