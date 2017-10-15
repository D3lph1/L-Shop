{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.shop')

@section('title')
    @lang('content.admin.news.edit.title')
@endsection

@section('content')
    <div id="content-container">
        <div class="z-depth-1 content-header text-center">
            <h1><i class="fa fa-newspaper-o fa-left-big"></i>@lang('content.admin.news.edit.title')</h1>
        </div>
        <div class="product-container">
            <form method="post" action="{{ route('admin.news.edit.save', ['currentServer' => $currentServer->getId(), 'id' => $news->id]) }}">
                <div class="md-form mt-1">
                    <i class="fa fa-font prefix"></i>
                    <input type="text" name="news_title" id="news-title" class="form-control" value="{{ $news->getTitle() }}">
                    <label for="news-title">@lang('content.admin.news.add.name')</label>
                </div>

                <textarea name="news_content" id="page-content">{{ $news->getContent() }}</textarea>

                <div class="card card-block mt-3">
                    <div class="flex-row">
                        {{ csrf_field() }}
                        <button class="btn btn-info">@lang('content.admin.save')</button>
                        <a href="{{ route('admin.news.remove', ['server' => $currentServer->getId(), 'id' => $news->getId()]) }}" class="btn danger-color">@lang('content.admin.news.edit.remove')</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('js')
    @include('components.admin_editor_init')
@endsection
