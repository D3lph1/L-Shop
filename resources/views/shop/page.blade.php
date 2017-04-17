{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    {{ $page->title }}
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1>{{ $page->title }}</h1>
        </div>
        <div class="product-container">
            <div class="card card-block f-card">
                <p class="card-text">
                    {!! $page->content !!}
                </p>
            </div>
        </div>
    </div>
@endsection
