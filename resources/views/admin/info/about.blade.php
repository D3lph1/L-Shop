{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.other.info.about.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-info fa-lg fa-left-big"></i> @lang('content.admin.other.info.about.title')</h1>
        </div>
        <div id="logo-block">
            <div class="logo-img">
                <img src="{{ asset('img/admin/logo_small.png') }}" alt="logo" class="c-logo">
            </div>
            <div class="logo-text text-depth">
                <h1>L - Shop</h1>
            </div>
        </div>

        <div class="mt-3 mb-5 ml-5 mr-5">
            <p>@lang('content.admin.other.info.about.description')</p>
            <div class="table-responsive">
                <table class="table table-sm">
                    <tbody>
                    <tr>
                        <td>@lang('content.admin.other.info.about.lshop_version')</td>
                        <td>0.5.0 (BETA)</td>
                    </tr>
                    <tr>
                        <td>@lang('content.admin.other.info.about.laravel_version')</td>
                        <td>5.5.4</td>
                    </tr>
                    <tr>
                        <td>@lang('content.admin.other.info.about.github')</td>
                        <td><a href="https://github.com/D3lph1/L-shop" target="_blank">https://github.com/D3lph1/L-shop</a></td>
                    </tr>
                    <tr>
                        <td>@lang('content.admin.other.info.about.rubukkit')</td>
                        <td><a href="http://rubukkit.org/threads/l-shop-open-source.133265/" target="_blank">http://rubukkit.org/threads/l-shop-open-source.133265/</a></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-md-12">
            <div class="text-center mb-3">
                <h4>@lang('content.admin.other.info.about.developers')</h4>
                <hr>
            </div>

            <div class="media">
                <a class="media-left waves-light">
                    <img class="rounded-circle" src="{{ asset('img/admin/developers/D3lph1.png') }}" alt="Generic placeholder image" height="100" width="100">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">D3lph1 <a href="https://vk.com/d3lph1" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-vk"></i></a><a href="https://github.com/D3lph1" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-github"></i></a><a href="http://rubukkit.org/members/d3lph1.94641/" target="_blank" class="btn btn-primary btn-sm">RuBukkit.org</a></h4>
                    <p>@lang('content.admin.other.info.about.d3lph1_description')</p>
                </div>
            </div>

            <div class="media">
                <a class="media-left waves-light">
                    <img class="rounded-circle" src="{{ asset('img/admin/developers/WhileD0S.png') }}" alt="Generic placeholder image" height="100" width="100">
                </a>
                <div class="media-body">
                    <h4 class="media-heading">WhilD0S <a href="https://vk.com/whiled0s" target="_blank" class="btn btn-primary btn-sm"><i class="fa fa-vk"></i></a></h4>
                    <p>@lang('content.admin.other.info.about.whiled0s_description')</p>
                </div>
            </div>
        </div>
    </div>
@endsection
