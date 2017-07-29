{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.other.rcon.title')
@endsection

@section('content')
    <div style="display: none;">
        <div id="rcon-selected-server">@lang('messages.admin.rcon.selected_server')</div>
        <div id="rcon-empty-input">@lang('messages.admin.rcon.empty_input')</div>
        <div id="rcon-connect-error">@lang('messages.admin.rcon.connect_error')</div>
    </div>

    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-terminal fa-left-big"></i>@lang('content.admin.other.rcon.title')</h1>
        </div>
        <div class="product-container">
            <div class="text-right">
                <div class="btn-group mb-1 mr-5">
                    <button class="btn btn-info dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">@lang('content.all.server')</button>

                    <div class="dropdown-menu">
                        @foreach($servers as $server)
                            <a data-server-id="{{ $server->id }}" class="dropdown-item rcon-dropdown-item">{{ $server->name }}</a>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="alert alert-info text-center rcon-choose-server">
                @lang('content.admin.other.rcon.select_server')
            </div>

            @foreach($servers as $server)
                <div class="row rcon-server" data-server-id="{{ $server->id }}" style="display: none">
                    <div class="col-12 rcon-area" data-server-id="{{ $server->id }}">
                        <ul class="list-group rcon-list" data-server-id="{{ $server->id }}">
                        </ul>
                    </div>
                    <div class="col-md-10 mt-2">
                        <div class="md-form">
                            <input type="text" class="input-alternate rcon-input" data-server-id="{{ $server->id }}" data-url="{{ route('admin.other.rcon.send', ['server' => $currentServer, 'send' => $server->id]) }}" placeholder="@lang('content.admin.other.rcon.enter_cmd')">
                        </div>
                    </div>

                    <div class="col-md-2 mt-2">
                        <div class="md-form">
                            <button class="btn btn-info btn-sm rcon-btn" data-server-id="{{ $server->id }}" data-url="{{ route('admin.other.rcon.send', ['server' => $currentServer, 'send' => $server->id]) }}">@lang('content.admin.other.rcon.exec')</button>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="card card-block mt-1 rcon-options" style="display: none">
                <h4 class="card-title">@lang('content.admin.other.rcon.options')</h4>
                <p class="card-text"></p>
                <div class="flex-row">
                    <p>
                        <input type="checkbox" id="rcon-hide-sent" value="1">
                        <label for="rcon-hide-sent" class="ckeckbox-label">
                            <span class='ui'></span>
                            @lang('content.admin.other.rcon.hide_sent')
                        </label>
                    </p>
                    <p>
                        <input type="checkbox" id="rcon-colorize" checked="checked" value="1">
                        <label for="rcon-colorize" class="ckeckbox-label"  data-toggle="popover" data-placement="top" data-trigger="hover" title="@lang('components.popover.title')" data-content="@lang('content.admin.other.rcon.colorize_popover')">
                            <span class='ui'></span>
                            @lang('content.admin.other.rcon.colorize')
                        </label>
                    </p>
                </div>
            </div>
        </div>
    </div>
@endsection