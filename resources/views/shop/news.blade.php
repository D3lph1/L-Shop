{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    {{ $news->getTitle() }}
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1>{{ $news->getTitle() }}</h1>
        </div>
        <div class="product-container">
            <div class="card card-block f-card">
                <p class="card-text">
                    {!! $news->getContent() !!}
                </p>
                <hr>
                <div class="row">
                    <div class="col-6 text-left">
                        <i class="fa fa-user"></i>
                        {{ $news->getUser()->getUsername() }}
                    </div>
                    <div class="col-6 text-right">
                        <i class="fa fa-calendar"></i>
                        {{ $news->getCreatedAt() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
