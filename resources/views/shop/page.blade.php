{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    {{ $page->title }}
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1>{{ $page->title }}</h1>
        </div>
        <div class="product-container">
            {!! $page->content !!}
        </div>
    </div>
@endsection