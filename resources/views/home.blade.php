@extends('layout')

@section('content')
    <!-- Hero Section -->
    <header class="bg-dark text-white text-center py-5 mb-4">
        <div class="container">
            <h1 class="display-4 fw-bold">Добро пожаловать в PizzaLaravel!</h1>
            <p class="lead">Свежие, горячие и вкусные пиццы — прямо к вашему столу</p>
            <a href="#menu" class="btn btn-warning btn-lg mt-3">Смотреть меню</a>
        </div>
    </header>

    <!-- Menu Section -->
    <section id="menu" class="container my-5">
        <h2 class="text-center mb-4">Наше меню</h2>

        @if($categories->isEmpty())
            <p class="text-center text-muted">Меню временно недоступно.</p>
        @else
            @foreach($categories as $category)
                @if($category->products->isNotEmpty())
                    <h3 class="border-bottom pb-2">{{ $category->name }}</h3>
                    <div class="row g-4">
                        @foreach($category->products as $product)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card h-100 shadow-sm">
                                    <!-- Изображение -->
                                    <div class="bg-light d-flex align-items-center justify-content-center"
                                         style="height: 200px;">
                                        ><img src="{{\Illuminate\Support\Facades\Storage::url($product->image)}}"
                                              class="rounded mx-auto d-block" alt="на фото изображено {{$product->description}}" width="150"
                                              height="150">"
                                    </div>

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $product->name }}</h5>

                                        <!-- Выбор размера -->
                                        <form action="{{ route('cart.items.store') }}" method="POST" class="mt-auto">
                                            @csrf
                                            @method('POST')
                                            <!-- Размеры -->
                                            <div class="mb-2">
                                                <label class="form-label fw-bold">Размер:</label>
                                                @foreach($product->sizes as $size)
                                                    @php
                                                        $price = $product->price + $size->price_adjustment;
                                                    @endphp
                                                    <div class="form-check">
                                                        <input
                                                                class="form-check-input"
                                                                type="radio"
                                                                name="product_size_id"
                                                                value="{{ $size->id }}"
                                                                id="size_{{ $size->id }}"
                                                                @if($loop->first) checked @endif
                                                        >
                                                        <label class="form-check-label" for="size_{{ $size->id }}">
                                                            {{ $size->size_name }}
                                                            ({{ number_format($price, 0, ',', ' ') }} ₽)
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>

                                            <!-- Количество -->
                                            <div class="mb-3">
                                                <label class="form-label">Количество:</label>
                                                <input
                                                        type="number"
                                                        name="quantity"
                                                        value="1"
                                                        min="1"
                                                        max="10"
                                                        class="form-control form-control-sm"
                                                >
                                            </div>

                                            <!-- Кнопка -->
                                            <button type="submit" class="btn btn-warning w-100">
                                                <i class="bi bi-cart-plus"></i> В корзину
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @endforeach
        @endif
    </section>
@endsection
{{--@extends('layout')--}}

{{--@section('content')--}}
{{--    <h1>Добро пожаловать в нашу пицццерию!</h1>--}}
{{--    @dump($products)--}}
{{--    <div class="container-md">--}}
{{--        <table class="table">--}}
{{--            <thead>--}}
{{--            <tr>--}}
{{--                <th>Категория</th>--}}
{{--                <th>Изображение</th>--}}
{{--                <th>Название</th>--}}
{{--                <th>размеры</th>--}}
{{--                <th>цена</th>--}}
{{--            </tr>--}}
{{--            </thead>--}}
{{--            <tbody>--}}

{{--            @foreach($products as $product)--}}
{{--                <tr>--}}
{{--                    <td>{{$product->category->name}}</td>--}}
{{--                    <td><img src="{{\Illuminate\Support\Facades\Storage::url($product->image)}}"--}}
{{--                             class="rounded mx-auto d-block" alt="на фото изображено {{$product->name}}" width="100"--}}
{{--                             height="100">--}}
{{--                    </td>--}}
{{--                    <td>{{$product->name}}</td>--}}
{{--                    <td>--}}

{{--                        <select id="size_name" name="size_name">--}}
{{--                            @foreach($product->sizes as $size)--}}
{{--                                <option value="{{$size->id}}">{{$size->size_value}}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}

{{--                    </td>--}}
{{--                </tr>--}}
{{--            @endforeach--}}
{{--            </tbody>--}}
{{--        </table>--}}


{{--        {{($product->name)}}--}}
{{--        @foreach($product->sizes as $size)--}}
{{--            <select id="size_name" name="size_name">--}}
{{--                <option value="{{$size->id}}">{{$size->size_value}}</option>--}}

{{--            </select>--}}
{{--            {{$size->size_name}}--}}
{{--        @endforeach--}}


{{--    </div>--}}
{{--@endsection--}}
