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
            <div class="md-form" style="margin-top: 30px;">
                <i class="fa fa-search prefix" aria-hidden="true" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" title="Подсказка"
                   data-content="Введите сюда логин, почту, баланс, дабы осуществить поиск по пользователям. Так же, вы можете искать пользователей, используя спец. правила.
                   Так, запрос <strong>&gt;520</strong> выберет всех пользователей, баланс которых больше 520. <strong>&lt;100</strong> - меньше 100. <strong>=0</strong> - Тех, у кого на балансе нет средств."></i>

                <input type="text" id="admin-users-search" class="form-control" data-toggle="dropdown"  data-url="{{ route('admin.users.search', ['server' => $currentServer->id]) }}">
                <label for="admin-users-search">Искать пользователей</label>

                <div id="admin-users-search-results" class="dropdown-menu" style="width: 100%; max-height: 400px; overflow: auto">
                    <a class="dropdown-item disabled">Начните вводить...</a>
                </div>
            </div>
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
                            <td>
                                @php($ban = app(App\Services\Ban::class, ['user' => $user, 'repository' => app(\App\Repositories\BanRepository::class)]))
                                @php($ban->setBan($user->ban))

                                @if($ban->isBanned())
                                    <span class="banned_span" data-toggle="popover" data-placement="left" data-trigger="hover" title="Информация о блокировке" data-content="{{ build_ban_message($ban->getBan()->until, $ban->getBan()->reason) }}">Заблокирован</span>
                                @else
                                    @if(\Activation::completed($user))
                                        <span class="activated_span" data-toggle="popover" data-placement="left" data-trigger="hover" title="Информация о подтверждении" data-content="Аккаунт этого пользователя подтвержден {{ dt($user->activations[count($user->activations) - 1]->completed_at) }}.">Подтвержден</span>
                                    @else
                                        <a href="{{ route('admin.users.complete', ['server' => $currentServer->id, 'user' => $user->id]) }}" class="btn green btn-sm">Подтвердить</a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            {{ $users->links('components.pagination') }}
        </div>
    </div>
@endsection
