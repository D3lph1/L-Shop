{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
@extends('layouts.auth')

@section('title')
    @lang('content.errors.404.title')
@endsection

@section('content')
    <div class="text-center mt-6">
        <div class="alert alert-danger">
            <h1>@lang('content.errors.404.content')</h1>
        </div>
        <a href="{{ route('index') }}" class="btn danger-color">@lang('content.errors.404.btn')</a>
    </div>
@endsection
