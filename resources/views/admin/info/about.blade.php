@extends('layouts.shop')

@section('title')
    О проекте L-Shop
@endsection

@section('content')
    <div id="content-container">
        <div id="cart-header" class="z-depth-1">
            <h1><i class="fa fa-info fa-lg fa-left-big"></i>О системе L-Shop</h1>
        </div>
        <div id="logo-block">
            <div class="logo-img">
                <img src="{{ asset('img/logo_small.png') }}" alt="logo" class="c-logo">
            </div>
            <div class="logo-text text-depth">
                <h1>L - Shop</h1>
            </div>
        </div>
        <div class="col-md-12">
            <div class="media">
                <a class="media-left waves-light">
                    <img class="rounded-circle" src="{{ asset('img/admin/developers/D3lph1.png') }}" alt="Generic placeholder image" height="100" width="100">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">D3lph1 <a href="" class="btn btn-info btn-sm"><i class="fa fa-vk" aria-hidden="true"></i></a></h4>
                    <p>Программный код</p>
                </div>
            </div>

            <div class="media">
                <a class="media-left waves-light">
                    <img class="rounded-circle" src="https://mdbootstrap.com/img/Photos/Avatars/avatar-13.jpg" alt="Generic placeholder image">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">WhilD0S</h4>
                    <p>Дизайн и верстка</p>
                </div>
            </div>
        </div>
    </div>
@endsection
