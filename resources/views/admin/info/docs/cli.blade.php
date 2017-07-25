{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    Документация по CLI L - Shop
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-terminal fa-left-big"></i>Документация по CLI L - Shop</h1>
        </div>
        <div class="card card-block">
            {!! $data !!}
        </div>
    </div>
@endsection
