@extends('layout')

@section('content')
    <a class="btn btn-primary" href="{{ route('categories.index') }}">Все категории</a>
    <p>{{$category->name}}</p>
    <a class="btn btn-warning" href="{{ route('categories.edit', $category) }}">Редактировать категорию</a>
@endsection
