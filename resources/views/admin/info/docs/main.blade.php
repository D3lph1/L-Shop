{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Основные сведения по работе с системой
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-info fa-left-big"></i>Основные сведения по работе с системой</h1>
        </div>
        <div class="card card-block">
            {!! $data !!}
        </div>
    </div>
@endsection
