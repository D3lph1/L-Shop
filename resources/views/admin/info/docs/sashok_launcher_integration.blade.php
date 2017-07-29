{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Гайд по интеграции Sashok724's Launcher
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-link fa-left-big"></i> Гайд по интеграции Sashok724's Launcher</h1>
        </div>
        <div class="card card-block">
            {!! $data !!}
        </div>
    </div>
@endsection
