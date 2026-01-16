@extends('layout')

@section('content')
    <h1>Изменить {{$product->name}}</h1>

    <form action="{{ route('products.update', $product) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-file form-file-sm">
            <input type="file" class="form-file-input" id="customFileSm" name="image">
        </div>
        <div>
            <select class="form-select" aria-label="Default select example" name="category_id">
                <option value="{{old('id', $product->category->id)}}"
                        selected>{{old('name', $product->category->name)}}</option>
                @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                @endforeach
            </select>
        </div>
        <div>
            <label for="name" class="form-label">Название:</label>
            <input type="text" name="name" value="{{old('name', $product->name)}}" class="form-control" required>
        </div>
        <div>
            <label for="description" class="form-label">Описание:</label>
            <textarea name="description" class="form-control">{{old('description', $product->description)}}</textarea>
        </div>
        <div>
            <label for="price" class="form-label">Цена:</label>
            <input type="text" class="form-control" name="price" value="{{old('price', $product->price)}}">
        </div>

        <button type="submit">Отправить</button>
    </form>
@endsection
