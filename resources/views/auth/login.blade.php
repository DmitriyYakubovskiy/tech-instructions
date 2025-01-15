@extends('layouts.app')

@section('content')
<div class="login-form">
    <h2>Вход</h2>
    <form class="form" role="form" method="POST">
        @csrf
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" сlass="@error('email') is-invalid @enderror">
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password" class="@error('password') is-invalid @enderror">
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group custom-container">
            <label for="captcha">Подтвердите, что Вы не робот:</label>
            <img id="captcha-image" class="mt-2" src="{{ captcha_src() }}" alt="captcha">
            <input type="text" name="captcha" class="form-control @error('captcha') is-invalid @enderror mt-2" placeholder="Введите капчу">
            @error('captcha')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror

            <button type="button" id="refresh-captcha" class="btn btn-secondary mt-2">Обновить капчу</button>
        </div>

        <button type="submit" class="btn-link">Войти</button>

        <div id="error-messages" class="mt-3"></div>
    </form>
</div>

<script>
    document.getElementById('refresh-captcha').onclick = function() {
        var captchaImage = document.getElementById('captcha-image');
        captchaImage.src = '{{ captcha_src() }}' + '?t=' + (new Date()).getTime();

        document.querySelector('input[name="captcha"]').value = '';
    };

    $('.form').on('submit', function(event) {
        event.preventDefault();
        var th = $(this);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/login",
            type: "POST",
            data: th.serialize(),
            success: function(data) {
                window.location = '/';
                console.log('Успешно');
            },
            error: function(err) {

                var captchaImage = document.getElementById('captcha-image');
                captchaImage.src = '{{ captcha_src() }}' + '?t=' + (new Date()).getTime();
                document.querySelector('input[name="captcha"]').value = '';

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
