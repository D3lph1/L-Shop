@extends('layout.shop')

@section('title')
    {{ $page->getTitle() }}
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1>{{ $page->getTitle() }}</h1>
        </div>
        <div class="product-container">
            <div class="card card-block f-card">
                <p class="card-text">
                    {!! $page->getContent() !!}
                </p>
            </div>
        </div>
    </div>
@endsection
