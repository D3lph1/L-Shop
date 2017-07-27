{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.servers.list.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-server fa-lg fa-left-big"></i>@lang('content.admin.servers.list.title')</h1>
        </div>
        <div class="mb-1">
            <a href="{{ route('admin.servers.add', ['server' => $currentServer->id]) }}" class="btn btn-info btn-block">@lang('content.admin.servers.list.create')</a>
        </div>
        <div id="a-server-edit">
            @foreach($servers as $server)
                <div class="a-s-e-block z-depth-1">
                    <div class="a-s-e-header text-center">
                        <h3><span class="pointer"data-toggle="tooltip" data-placement="top"  title="Идентификатор сервера">[{{ $server->id }}]</span> {{ $server->name }}</h3>
                    </div>
                    @if(isset($server->categories))
                        <div class="a-s-e-cat text-center">
                            <p>@lang('content.admin.servers.add.categories.title')</p>
                            <ul class="text-left">
                                @foreach($server->categories as $category)
                                    <li>{{ $category }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="a-s-e-btns text-center">
                        @if($server->enabled)
                            <form class="a-s-e-btns" method="post" action="{{ route('admin.servers.disable', ['server' => $currentServer->id, 'disable' => $server->id]) }}">
                                {!! csrf_field() !!}
                                <a class="btn btn-info btn-md" href="{{ route('admin.servers.edit', ['server' => $currentServer->id, 'edit' => $server->id]) }}">@lang('content.admin.servers.list.edit')</a>
                                <button class="btn btn-mdb btn-md">@lang('content.admin.servers.list.disable')</button>
                            </form>
                        @else
                            <form class="a-s-e-btns" method="post" action="{{ route('admin.servers.enable', ['server' => $currentServer->id, 'enable' => $server->id]) }}">
                                {!! csrf_field() !!}
                                <a class="btn btn-info btn-md" href="{{ route('admin.servers.edit', ['server' => $currentServer->id, 'edit' => $server->id]) }}">@lang('content.admin.servers.list.edit')</a>
                                <button class="btn btn-warning btn-md">@lang('content.admin.servers.list.enable')</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
