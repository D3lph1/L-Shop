{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Редактировать пользователей
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-users fa-lg fa-left-big"></i>Редактировать пользователей</h1>
        </div>
        <div class="product-container">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Имя пользователя</th>
                        <th>Почта</th>
                        <th>Баланс</th>
                        <th>Администратор</th>
                        <th>Редактировать</th>
                        <th>Статус аккаунта</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->balance }}</td>
                            <td>@if($user->hasAccess('user.admin')) <strong>Да</strong> @else Нет @endif</td>
                            <td><a href="{{ route('admin.users.edit', ['server' => $currentServer->id, 'edit' => $user->id]) }}" class="btn btn-info btn-sm">Редактировать</a></td>
                            <td>@if(\Activation::completed($user)) Подтвержден @else <a href="{{ route('admin.users.complete', ['server' => $currentServer->id, 'user' => $user->id]) }}" class="btn btn-success btn-sm">Подтвердить</a> @endif</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->links('components.pagination') }}
        </div>
    </div>
@endsection
