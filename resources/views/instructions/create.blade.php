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

        <div id="error-messages" class="mt-3"></div>
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
        error: function(err) {
            console.log(err.responseJSON);
                $('#error-messages').empty();

                if (err.responseJSON.errors) {
                    $.each(err.responseJSON.errors, function(i, error) {
                        $('#error-messages').append('<div class="alert alert-danger">'+ error[0] +'</div>');
                    });
                }
                else if (err.status === 422) {
                    $.each(err.responseJSON.errors, function(field, messages) {
                        messages.forEach(function(message) {
                            $('#error-messages').append('<div class="alert alert-danger">' + message + '</div>');
                        });
                    });
                } else {
                    $('#error-messages').append('<div class="alert alert-danger">Неверные данные.</div>');
                }
        }
    });
});
</script>
@endsection
