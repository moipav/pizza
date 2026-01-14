@extends('layout')

@section('content')
    <h1>Доступные статусы:</h1>
    <a href="{{ route('statuses.create') }}" class="btn btn-primary">Добавить новый статус</a>

    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        @foreach($statuses as $status)
            <tr>
                <td>{{ $status->id }}</td>
                <td>{{ $status->name }}</td>
                <td>
                    <a class="btn btn-primary" href="{{ route('statuses.show', $status) }}">Просмотр</a>
                    <a class="btn btn-warning" href="{{ route('statuses.edit', $status) }}">Редактировать</a>
                    <form action="{{ route('statuses.destroy', $status) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit" onclick="return confirm('Удалить?')">Удалить</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
