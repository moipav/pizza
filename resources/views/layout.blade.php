<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>pizza</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="/pizza.png">
</head>
<body>
<header>
    <ul class="nav d-flex">
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/">Главная страница</a>
        </li>
{{--        @if(auth()->check() && auth()->user()->is_admin)--}}
        <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/users">users</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="/statuses">statuses</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/categories">Категории</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/products">Продукты</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="/product-sizes">размеры</a>
        </li>
        <li class="nav-item">
            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
        </li>
{{--        @endif--}}
        <li class="nav-item ms-auto">
            <a class="nav-link" href="/cart">Корзина</a>
        </li>
    </ul>

</header>
@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@yield('content')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
