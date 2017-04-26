{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    {{ $news->title }}
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1>{{ $news->title }}</h1>
        </div>
        <div class="product-container">
            <div class="card card-block f-card">
                <p class="card-text">
                    {!! $news->content !!}
                </p>
            </div>
        </div>
    </div>
@endsection
