<!-- resources/views/instructions/show.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $instruction->title }}</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>{{ $instruction->title }}</h1>

        <p><strong>Описание:</strong></p>
        <p>{{ $instruction->description }}</p>

        <!-- Ссылка для скачивания файла -->
        @if ($instruction->file_path)
            <a href="{{ asset($instruction->file_path) }}" class="btn btn-success">Скачать инструкцию</a>
        @endif

        <!-- Кнопка "Назад" -->
        <a href="{{ route('instructions.index') }}" class="btn btn-secondary mt-3">Назад к списку</a>

        <!-- Форма для жалобы на инструкцию -->
        @if (auth()->check())
            <h3>Пожаловаться на инструкцию</h3>
            <form action="{{ route('instructions.report', $instruction->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="complaint">Ваше сообщение:</label>
                    <textarea name="complaint" id="complaint" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-warning">Отправить жалобу</button>
            </form>
        @endif
    </div>
</body>
</html>