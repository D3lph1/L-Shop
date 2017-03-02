@extends('layouts.shop')

@section('title')
    Документация
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-book fa-left-big"></i>Документация</h1>
        </div>
        <div class="card card-block">
            <h4 class="card-title">Документация по API L - Shop</h4>
            <p class="card-text"></p>
            <div class="flex-row">
                <a href="{{ route('admin.info.docs.api', ['server' => $currentServer->id]) }}" class="btn btn-info">Читать</a>
            </div>
        </div>
    </div>
@endsection
