@extends('layouts.app')

@section('content')
<div class="container mt-4 custom-container">
    <div class="container mb-4 mt-1 custom-container">
        <h1 class="text-dark">Инструкции</h1>
        <form method="GET" action="{{ route('instructions.index') }}" class="mb-4">
            @csrf
            <div class="input-group">
                <input type="text" name="search" value="{{ old('search') }}" placeholder="Поиск по названию" class="form-control">
                <button type="submit" class="btn btn-primary">Искать</button>
            </div>
        </form>

        @auth
            <div class="mb-4">
                <a href="{{ route('instructions.create') }}" class="btn btn-success">Добавить инструкцию</a>
            </div>
        @endif
    </div>

    @if ($instructions->isEmpty())
        <p class="text-dark">Нет найденных инструкций.</p>
    @else
        <div class="row">
            @foreach ($instructions as $instruction)
                <div class="col-md-4 mb-4">
                    <div class="card custom-card h-100">
                        <img src="{{ asset($instruction->icon_path) }}" alt="{{ $instruction->title }} иконка" class="card-img-top" style="width: 100%; height: 350px; object-fit: cover;">

                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="{{ route('instructions.show', $instruction) }}" class="text-primary">{{ $instruction->title }}</a>
                            </h5>
                            <p class="card-text text-muted">{{ Str::limit($instruction->content, 40) }}</p>
                        </div>

                        <form action="{{ route('instructions.destroy', $instruction) }}" method="POST" class="m-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>

@endsection
