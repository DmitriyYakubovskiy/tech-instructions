@extends('layouts.app')

@section('content')
<div class="container custom-container">
    <div class="container custom-container">
        <p class="text-center mb-4" style="font-weight: 600; font-size: 24px">Это инструкция по {{ $instruction->title }}. Здесь вы найдете все необходимые шаги и рекомендации для выполнения задачи.</p>

        @if ($instruction->icon_path)
            <div class="d-flex justify-content-center mb-3">
                <img src="{{ asset($instruction->icon_path) }}" alt="{{ $instruction->title }} лого" class="img-fluid" style="max-width: 450px;">
            </div>
        @endif

        <p style="font-size: 20px;">Описание: </p>
        <p>{{ $instruction->content }}</p>

        @if ($instruction->file_path)
            <a href="{{ asset($instruction->file_path) }}" class="btn btn-primary">Скачать инструкцию</a>
        @endif
    </div>

    <div class="container custom-container mt-3">
        <p class="mt-1" style="font-size: 18px">Подать жалобу:</p>

        <form id="complaint-form" action="{{ route('instructions.complain', $instruction->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="reason">Причина:</label>
                <textarea name="reason" id="reason" rows="1" class="form-control" required></textarea>
            </div>
            <button type="submit" min='5' class="btn btn-danger mt-2">Подать жалобу</button>
        </form>

        <div id="response-message" class="mt-3"></div>
    </div>

    @if(Auth::user()->role === 'admin')
        <div class="container custom-container mt-3">
            <h3 class="mt-1" style="font-size: 18px">Жалобы:</h3>
            <ul id="complaint-list" class="list-group">
                @foreach ($complaints as $complaint)
                <li class="list-group-item mb-4">
                    <strong>Автор:</strong> {{ $complaint->user ? $complaint->user->name : 'Неизвестный автор' }}
                    <strong>{{ $complaint->created_at->format('d.m.Y H:i') }}</strong><br>
                    {{ $complaint->reason }}<br>
                </li>
                @endforeach
            </ul>
        </div>
    @endif
</div>

<script>
$(document).ready(function() {
    $('#complaint-form').on('submit', function(e) {
        e.preventDefault();
        console.log(1);
        $.ajax({
            url: $(this).attr('action'),
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                if (response.success) {
                    $('#response-message').html('<div class="alert alert-success">' + response.message + '</div>').fadeIn().delay(600).fadeOut();;

                    $('#complaint-list').empty();

                    $.each(response.complaints, function(index, complaint) {
                        $('#complaint-list').append(
                            '<li class="list-group-item mb-4">' +
                            '<strong>Автор:</strong> ' + (complaint.user ? complaint.user.name : 'Неизвестный автор') +
                            ' <strong>' + new Date(complaint.created_at).toLocaleString() + '</strong><br>' +
                            complaint.reason +
                            '</li>'
                        );
                    });
                    console.log(1);
                }
            },
            error: function(xhr) {
                var errors = xhr.responseJSON.errors;
                var errorMessage = '<div class="alert alert-danger">';
                $.each(errors, function(key, value) {
                    errorMessage += value[0] + '<br>';
                });
                errorMessage += '</div>';
                $('#response-message').html(errorMessage);
            }
        });
    });
});
</script>

@endsection
