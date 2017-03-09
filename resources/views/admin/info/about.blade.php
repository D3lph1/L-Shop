{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    О проекте L-Shop
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
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

        <div class="mt-3 mb-5 ml-5 mr-5">
            <p><strong>L - Shop</strong> - это проект с открытым исходным кодом, целая система, призванная помочь администраторам игровых серверов Minecraft упростить процесс продажи виртуальных товаров.</p>
            <table class="table table-sm">
                <tbody>
                <tr>
                    <td>Версия системы L - Shop</td>
                    <td>0.1.0 (BETA)</td>
                </tr>
                <tr>
                    <td>Версия фреймворка Laravel</td>
                    <td>5.4.11</td>
                </tr>
                <tr>
                    <td>GitHub репозиторий</td>
                    <td><a href="https://github.com/D3lph1/L-shop" target="_blank">https://github.com/D3lph1/L-shop</a></td>
                </tr>
                <!--<tr>
                    <td>Тема на RuBukkit.org</td>
                    <td><a href="http://rubukkit.org/" target="_blank">http://rubukkit.org/</a></td>
                </tr>-->
                </tbody>
            </table>
        </div>
        <div class="col-md-12">
            <div class="text-center mb-3">
                <h4>Разработчики</h4>
                <hr>
            </div>

            <div class="media">
                <a class="media-left waves-light">
                    <img class="rounded-circle" src="{{ asset('img/admin/developers/D3lph1.png') }}" alt="Generic placeholder image" height="100" width="100">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">D3lph1 <a href="https://vk.com/d3lph1" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-vk"></i></a><a href="https://github.com/D3lph1" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-github"></i></a><a href="http://rubukkit.org/members/d3lph1.94641/" target="_blank" class="btn btn-primary btn-sm">RuBukkit.org</a></h4>
                    <p><strong>Программный код</strong>. Вы можете обратиться ко мне за техничекой поддержкой.</p>
                </div>
            </div>

            <div class="media">
                <a class="media-left waves-light">
                    <img class="rounded-circle" src="{{ asset('img/admin/developers/WhileD0S.png') }}" alt="Generic placeholder image" height="100" width="100">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">WhilD0S <a href="https://vk.com/whiled0s" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-vk"></i></a></h4>
                    <p><strong>Дизайн и верстка</strong>. Вы можете обратиться ко мне для того, чтобы заказть разработку уникального дизайна для вашего сайта, в том числе, для сайта, базирующегося на системе L-Shop.</p>
                </div>
            </div>
        </div>
    </div>
@endsection
