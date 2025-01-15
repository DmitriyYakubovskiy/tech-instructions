@extends('layouts.app')

@section('content')
<div class="container custom-container mt-4">
    <h2>Все пользователи</h2>

    <div id="success-message" style="display:none;" class="alert alert-success"></div>

    <ul class="list-group" id="user-list">
        @foreach ($users as $user)
            <li class="list-group-item d-flex justify-content-between align-items-center mt-2" id="user-{{ $user->id }}">
                {{ $user->name }} ({{ $user->email }})
                <div>
                    @if ($user->is_blocked)
                        <button class="btn btn-warning btn-sm unblock-btn" data-id="{{ $user->id }}">Разблокировать</button>
                    @else
                        @if($user->email !== auth()->user()->email && $user->role !== "admin")
                            <button class="btn btn-danger btn-sm block-btn" data-id="{{ $user->id }}">Заблокировать</button>
                        @endif
                    @endif

                    @if($user->email !== auth()->user()->email && $user->role !== "admin")
                        <button class="btn btn-danger btn-sm delete-btn" data-id="{{ $user->id }}">Удалить</button>
                    @endif
                </div>
            </li>
        @endforeach
    </ul>
</div>

<script>
$(document).ready(function() {
    $('#user-list').on('click', '.delete-btn', function() {
        var userId = $(this).data('id');

        if (confirm('Вы уверены, что хотите удалить этого пользователя?')) {
            $.ajax({
                url: '/users/' + userId,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    _method: 'DELETE'
                },
                success: function(response) {
                    $('#success-message').text(response.success).fadeIn().delay(600).fadeOut();
                    $('#user-' + userId).remove();
                },
                error: function(xhr) {
                    alert('Произошла ошибка при удалении пользователя.');
                }
            });
        }
    });

    $('#user-list').on('click', '.block-btn', function() {
        var userId = $(this).data('id');

        $.ajax({
            url: '/users/' + userId + '/block',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#success-message').text(response.success).fadeIn().delay(2000).fadeOut();
                updateUserList(response.users);
            },
            error: function(xhr) {
                alert('Произошла ошибка при блокировке пользователя.');
            }
        });
    });

    $('#user-list').on('click', '.unblock-btn', function() {
        var userId = $(this).data('id');

        $.ajax({
            url: '/users/' + userId + '/unblock',
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#success-message').text(response.success).fadeIn().delay(2000).fadeOut();
                updateUserList(response.users);
            },
            error: function(xhr) {
                alert('Произошла ошибка при разблокировке пользователя.');
            }
        });
    });

    function updateUserList(users) {
        $('#user-list').empty();

        users.forEach(function(user) {
            var listItem = `<li class="list-group-item d-flex justify-content-between align-items-center" id="user-${user.id}">
                                ${user.name} (${user.email})
                                <div>`;

            if (user.is_blocked) {
                listItem += `<button class="btn btn-warning btn-sm unblock-btn" data-id="${user.id}">Разблокировать</button>`;
            } else {
                if (user.email !== '{{ auth()->user()->email }}' && user.role !== "admin") {
                    listItem += `<button class="btn btn-danger btn-sm block-btn" data-id="${user.id}">Заблокировать</button>`;
                }
            }

            if (user.email !== '{{ auth()->user()->email }}' && user.role !== "admin") {
                listItem += `<button class="btn btn-danger btn-sm delete-btn" data-id="${user.id}">Удалить</button>`;
            }

            listItem += `</div></li>`;
            $('#user-list').append(listItem);
        });
    }
});
</script>
@endsection
