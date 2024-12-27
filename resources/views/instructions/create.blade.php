<!-- resources/views/instructions/create.blade.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить инструкцию</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Добавить инструкцию</h1>

        <!-- Форма загрузки инструкции -->
        <form method="POST" action="{{ route('instructions.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Название инструкции:</label>
                <input type="text" name="title" id="title" class="form-control" required />
            </div>

            <div class="form-group">
                <label for="description">Описание:</label>
                <textarea name="description" id="description" class="form-control"></textarea>
            </div>

            <div class="form-group">
                <label for="file">Файл (PDF):</label>
                <input type="file" name="file" id="file" class="form-control" required accept=".pdf"/>
            </div>

            <!-- Кнопка отправки формы -->
            <button type="submit" class="btn btn-primary">Загрузить инструкцию</button>

            <!-- Кнопка "Назад" -->
            <a href="{{ route('instructions.index') }}" class="btn btn-secondary mt-3">Назад к списку</a>

        </form>

        <!-- Отображение ошибок валидации -->
        @if ($errors->any())
            <div class="alert alert-danger mt-3">
                Упс! Что-то пошло не так:
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</body>
</html>