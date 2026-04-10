@extends('layout')

@section('content')
{{--@dd($cart)--}}
<form action="{{ route('orders.store') }}" method="POST">
    @csrf
    <input type="text" name="address" value="{{old('address')}}" placeholder="Адрес доставки">
    <input type="tel" name="phone" value="{{old('phone')}}" placeholder="Телефон">
    <input type="email" name="email" value="{{ auth()->user()?->email ?? old('email')}}" placeholder="Email">

    <button type="submit" class="btn btn-success">Подтвердить заказ</button>
</form>
@endsection
