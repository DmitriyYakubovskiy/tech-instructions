<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Инструкции</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Список инструкций</h1>

        <!-- Форма поиска -->
        <form method="GET" action="{{ route('instructions.index') }}">
            <div class="form-group">
                <input type="text" name="search" class="form-control" placeholder="Поиск по названию..." value="{{ request('search') }}">
            </div>
            <button type="submit" class="btn btn-primary">Искать</button>
            <a href="{{ route('instructions.create') }}" class="btn btn-success">Добавить инструкцию</a>
        </form>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($instructions as $instruction)
                    <tr>
                        <td>{{ $instruction->title }}</td>
                        <td>{{ Str::limit($instruction->description, 50) }}</td>
                        <td>
                            <a href="{{ route('instructions.show', $instruction->id) }}" class="btn btn-info">Просмотреть</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $instructions->links() }} <!-- Пагинация -->
    </div>
</body>
</html>