@extends('layouts.auth')

@section('title')
    Выбор сервера
@endsection

@section('content')
    <!-- Select server page -->
    <div class="full-h flex-center pd-v-form" id="servers-list">
        <div class="card no-pdh z-depth-4 col-xl-4 col-md-6 col-sm-10 col-11">

            <div class="card-block">
                <div class="card-header d_orange text-center white-text z-depth-2">
                    <h1><i class="fa fa-check-square-o fa-lg fa-left"></i>Сервер</h1>
                </div>
                <div class="list-group no-shadow">
                    @foreach($servers as $server)
                        <a href="server/{{ $server->id }}" class="list-group-item waves-effect">{{ $server->name }}</a>
                    @endforeach
                </div>
            </div>
            <div class="card-footer text-center">
                @if($canExit)
                    <a href="{{ route('logout', []) }}" class="btn btn-primary btn-lg">Выйти<i class="fa fa-sign-out fa-right"></i></a>
                @elseif($canEnter)
                    <a href="signin" class="btn btn-primary btn-lg">Войти<i class="fa fa-sign-out fa-right"></i></a>
                @endif
            </div>
        </div>
    </div>
    <!-- End -->
@endsection
