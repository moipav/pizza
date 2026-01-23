@extends('layout')

@section('content')
    <h1>Добавить новый размер для продукта</h1>

    <form action="{{ route('product-sizes.store') }}" method="POST">
        @csrf
        <label for="product_id" class="frorm-label">Выберите или введите продукт</label>
        <select class="form-select" aria-label="Default select example" name="product_id">
            @foreach($products as $product)
                <option value="{{$product->id}}">{{$product->name}}</option>
            @endforeach
        </select>

        <div>
            <label for="size_name" class="form-label">Название размера</label>
            <input list="size_name" name="size_name" placeholder="Выберите или введите название" class="form-control"
                   required>

            <datalist id="size_name">
                @foreach($productSizeNames as $productSizeName)
                    <option value="{{$productSizeName}}">
                @endforeach
            </datalist>

            <div>
                <label for="size_value" class="form-label">Размер / объем:</label>
                <input list="size_value" name="size_value" placeholder="Выберите или введите название"
                       class="form-control" required>
                <datalist id="size_value">
                    @foreach($productSizeValues as $productSizeValue)
                        <option value="{{$productSizeValue}}">
                    @endforeach
                </datalist>
            </div>

            <div>
                <label for="unit" class="form-label">Единицы измерения:</label>
                <input list="unit" name="unit" placeholder="Выберите или введите название"
                       class="form-control" required>
                <datalist id="unit">
                    @foreach($productSizeUnits as $productSizeUnit)
                        <option value="{{$productSizeUnit}}">
                    @endforeach
                </datalist>
            </div>


            <div>
                <label for="price_adjustment" class="form-label">Добавочная стоимость</label>
                <input list="price_adjustment" name="price_adjustment" placeholder="Выберите или введите название"
                       class="form-control" required>
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
