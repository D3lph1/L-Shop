{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.pages.add.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-file fa-left-big"></i>@lang('content.admin.pages.add.title')</h1>
        </div>
        <div class="product-container">
            <form method="post" action="{{ route('admin.pages.add.save', ['currentServer' => $currentServer->id]) }}">
                <div class="md-form mt-1">
                    <i class="fa fa-font prefix"></i>
                    <input type="text" name="page_title" id="page-title" class="form-control" value="{{ old('page_title') }}">
                    <label for="page-title">Заголовок страницы</label>
                </div>

                <textarea name="page_content" id="page-content">@if(old('page_content')) {{ old('page_content') }} @else @lang('content.admin.pages.add.placeholder')@endif</textarea>

                <div class="mt-1">
                    <input type="checkbox" name="page_url_auto" id="page-url-auto" checked="checked" value="1">
                    <label for="page-url-auto" class="ckeckbox-label">
                        <span class='ui'></span>
                        Сгенерировать автоматически
                    </label>
                </div>

                <div class="md-form mt-1">
                    <i class="fa fa-link prefix"></i>
                    <input type="text" name="page_url" id="page-url" class="form-control" value="{{ old('page_url') }}" placeholder="Адрес страницы">
                    <label class="disabled" for="page-url"></label>
                </div>

                <div class="alert alert-info">
                    @lang('content.admin.pages.add.access', ['url' => urldecode(route('page', ['server' => $currentServer->id,'page' => '<строка, указанная выше>']))])
                </div>

                <div class="card card-block mt-3">
                    <div class="flex-row">
                        {{ csrf_field() }}
                        <button class="btn btn-info">@lang('content.admin.pages.add.save')</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    @include('components.admin_editor_init')
@endsection