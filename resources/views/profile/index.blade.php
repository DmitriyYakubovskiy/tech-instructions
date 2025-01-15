@extends('layouts.app')

@section('content')
<div class="container custom-container mt-4">
    <div class="container custom-container">
        <h2>Профиль пользователя</h2>

        <h2>Ваши данные:</h2>
        <ul class="list-group mb-4">
            <li class="list-group-item"><strong>Имя:</strong> {{ $user->name }}</li>
            <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
            <li class="list-group-item"><strong>Роль:</strong> {{ $user->role }}</li>
        </ul>
        @if(Auth::user()->role === 'admin')
            <a href="{{ route('users.index') }}" class="btn btn-info">Все пользователи</a>
        @endif
    </div>

    @if(Auth::user()->role === 'admin')
        <div class="container custom-container mt-4">
                <h3>Инструкции на утверждение: </h3>
                @if($instructions->isEmpty())
                    <p>Нет неутвержденных инструкций.</p>
                @else
                    <ul class="list-group" id="instructionList">
                        @foreach ($instructions as $instruction)
                            <li class="list-group-item" data-id="{{ $instruction->id }}">
                                <meta name="csrf-token" content="{{ csrf_token() }}">
                                {{ $instruction->title }}
                                <button type="button" class="btn btn-success btn-sm approve-btn ml-3">Одобрить</button>
                            </li>
                        @endforeach
                    </ul>
                @endif
        </div>
    @endif
</div>

<script>
$(document).ready(function() {
    $('.approve-btn').on('click', function() {
        var instructionId = $(this).closest('li').data('id');

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/instructions/' + instructionId + '/approve',
            type: 'POST',
            success: function(response) {
                $('#instructionList').find('li[data-id="' + instructionId + '"]').remove();
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = 'Произошла ошибка. Пожалуйста, попробуйте еще раз.';
                if (errors) {
                    errorMessage = errors.join(', ');
                }
                alert(errorMessage);
            }
        });
    });
});
</script>
@endsection
