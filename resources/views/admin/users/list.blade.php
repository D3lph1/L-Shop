{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.users.list.title')
@endsection

@section('content')
    <div style="display: none;">
        <div id="search-lets-typing">@lang('content.admin.users.list.search.lets_typing')</div>
        <div id="search-wait">@lang('content.admin.users.list.search.wait')</div>
        <div id="search-nothing">@lang('content.admin.users.list.search.nothing')</div>
    </div>

    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-users fa-lg fa-left-big"></i>@lang('content.admin.users.list.title')</h1>
        </div>
        <div class="product-container">
            <div class="md-form" style="margin-top: 30px;">
                <i class="fa fa-search prefix" aria-hidden="true" data-toggle="popover" data-placement="right" data-trigger="hover" data-html="true" title="@lang('components.popover.title')"
                   data-content="@lang('content.admin.users.list.search.popover')"></i>

                <input type="text" id="admin-users-search" class="form-control" data-toggle="dropdown"  data-url="{{ route('admin.users.search', ['server' => $currentServer->id]) }}">
                <label for="admin-users-search">@lang('content.admin.users.list.search.placeholder')</label>

                <div id="admin-users-search-results" class="dropdown-menu" style="width: 100%; max-height: 400px; overflow: auto">
                    <a class="dropdown-item disabled">@lang('content.admin.users.list.search.lets_typing')</a>
                </div>
            </div>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>@lang('content.admin.users.list.table.id')</th>
                        <th>@lang('content.admin.users.list.table.username')</th>
                        <th>@lang('content.admin.users.list.table.email')</th>
                        <th>@lang('content.admin.users.list.table.balance')</th>
                        <th>@lang('content.admin.users.list.table.admin')</th>
                        <th>@lang('content.admin.users.list.table.edit')</th>
                        <th>@lang('content.admin.users.list.table.status')</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <td>{{ $user->getId() }}</td>
                            <td>{{ $user->getUsername() }}</td>
                            <td>{{ $user->getEmail() }}</td>
                            <td>{{ $user->getBalance() }}</td>
                            <td>@if($user->hasAccess('user.admin')) <strong>@lang('content.all.yes')</strong> @else @lang('content.all.no') @endif</td>
                            <td><a href="{{ route('admin.users.edit', ['server' => $currentServer->getId(), 'edit' => $user->getId()]) }}" class="btn btn-info btn-sm">@lang('content.admin.users.list.table.edit')</a></td>
                            <td>
                                @if($ban->isBanned($user))
                                    <span class="banned_span" data-toggle="popover" data-placement="left" data-trigger="hover" title="@lang('content.admin.users.list.table.blocked_popover_title')" data-content="{{ build_ban_message($ban->get($user)->getUntil(), $ban->get($user)->getReason()) }}">@lang('content.admin.users.list.table.blocked')</span>
                                @else
                                    @if(\Activation::completed($user))
                                        <span class="activated_span" data-toggle="popover" data-placement="left" data-trigger="hover" title="@lang('content.admin.users.list.table.activated_popover_title')" data-content="@lang('content.admin.users.list.table.activated_info', ['date' => dt($user->getActivations()[count($user->activations) - 1]->getCompletedAt())])">@lang('content.admin.users.list.table.activated')</span>
                                    @else
                                        <a href="{{ route('admin.users.complete', ['server' => $currentServer->getId(), 'user' => $user->getId()]) }}" class="btn green btn-sm">@lang('content.admin.users.list.table.activate')</a>
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
