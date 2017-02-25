@extends('layouts.shop')

@section('title')
    Добавить сервер
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-server fa-lg fa-left-big"></i>Редактировать серверы</h1>
        </div>
        <div class="server-block-wrapper">
            @foreach($servers as $server)
                <div class="col-xs-3 col-md-4 col-sm-12 server-block">
                    <div class="card">
                        <div class="card-block">
                            <h4 class="card-title">{{ $server->name }}</h4>
                            @if(isset($server->categories))
                                <p class="card-text">
                                    <p class="text-center">Категории</p>
                                    <table class="table table-sm">
                                        <tbody>
                                        @foreach($server->categories as $category)
                                            <tr>
                                                <td>{{ $category }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </p>
                            @endif
                            <a href="#" class="btn danger-color btn-sm">Удалить</a>
                            <a href="#" class="btn btn-info btn-sm">Редактировать</a>
                            @if($server->enabled)
                                <a href="#" class="btn btn-warning btn-sm">Отключить</a>
                            @else
                                <a href="#" class="btn btn-info btn-sm">Включить</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
