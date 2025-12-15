@extends('layout')

@section('content')
    <h1>Доступные статусы:</h1>
    @foreach($statuses as $status)
        <p>{{$status->name}}</p>
    @endforeach
@endsection
