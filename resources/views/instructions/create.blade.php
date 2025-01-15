@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1>Добавление инструкции</h1>
    <div class="form-container custom-container">
        <form class="form" role="form">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Название</label>
                <input type="text" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="content" class="form-label">Содержимое</label>
                <textarea name="content" class="form-control" rows="5" required></textarea>
            </div>

            <div class="mb-3">
                <label for="icon" class="form-label">Загрузить лого инструкции</label>
                <input accept=".jpg, .jpeg, .png" type="file" name="icon" required class="form-control">
            </div>

            <div class="mb-3">
                <label for="file" class="form-label">Загрузить файл инструкции</label>
                <input accept=".jpg, .jpeg, .png, .pdf" type="file" name="file" required class="form-control">
            </div>

            <button type="submit" class="btn btn-success">Отправить на утверждение</button>
        </form>

        <div id="message" class="mt-3"></div>
    </div>
</div>

<script>
$('.form').on('submit',function(event){
    event.preventDefault();

    $('#message').html('');

    var formData = new FormData(this);

    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    $.ajax({
        url: "/instructions/create",
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log('Успешно')
            window.location = '/';
        },
        error: function(xhr) {
            console.log(xhr);
            var errors = xhr.responseJSON.errors;
            console.log(errors);
            var errorMessage = '<p class="text-danger">Пожалуйста, исправьте следующие ошибки:</p><ul>';
            $.each(errors, function(key, value) {
                errorMessage += '<li>' + value[0] + '</li>';
            });
            errorMessage += '</ul>';
            $('#message').html(errorMessage);
        }
    });
});
</script>
@endsection
