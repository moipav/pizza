@extends('layout')

@section('content')
    <h1>Изменить размер для продукта {{$productSize->product->name}} . {{$productSize->size_value}}</h1>

    <form action="{{ route('product-sizes.update', $productSize) }}" method="POST">
        @csrf
        @method('PUT')
        <label for="product_id" class="form-label">Выберите или введите продукт</label>
        <select class="form-select" aria-label="Default select example" name="product_id">
            <option value="{{old('id', $productSize->product->id)}}"
                    selected>{{old('name', $productSize->product->name)}}</option>
            @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
            @endforeach
        </select>

        <div>
            <label for="size_name" class="form-label">Название размера</label>
            <input list="size_name" name="size_name" class="form-control"
                   required value="{{old('size_name', $productSize->size_name)}}">

            <datalist id="size_name">
                @foreach($productSizeNames as $productSizeName)
                    <option value="{{$productSizeName}}">
                @endforeach
            </datalist>

            <div>
                <label for="size_value" class="form-label">Размер / объем:</label>
                <input list="size_value" name="size_value"
                       class="form-control" required value="{{old('size_value', $productSize->size_value)}}">
                <datalist id="size_value">
                    @foreach($productSizeValues as $productSizeValue)
                        <option value="{{$productSizeValue}}">
                    @endforeach
                </datalist>
            </div>

            <div>
                <label for="unit" class="form-label">Единицы измерения:</label>
                <input list="unit" name="unit"
                       class="form-control" required value="{{old('unit', $productSize->unit)}}">
                <datalist id="unit">
                    @foreach($productSizeUnits as $productSizeUnit)
                        <option value="{{$productSizeUnit}}">
                    @endforeach
                </datalist>
            </div>


            <div>
                <label for="price_adjustment" class="form-label">Добавочная стоимость</label>
                <input list="price_adjustment" name="price_adjustment" class="form-control" required
                       value="{{old('price_adjustment', $productSize->price_adjustment)}}">
                <datalist id="price_adjustment">
                    @foreach($priceAdjustments as $priceAdjustment)
                        <option value="{{$priceAdjustment}}">
                    @endforeach
                </datalist>
            </div>

            <button type="submit">Отправить</button>
        </div>
    </form>
@endsection
