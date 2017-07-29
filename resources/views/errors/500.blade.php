@extends('layouts.auth')

@section('title')
    @lang('content.errors.500.title')
@endsection

@section('content')
    <div class="text-center mt-6">
        <div class="alert alert-danger">
            <h1>@lang('content.errors.500.content')</h1>
        </div>
    </div>
@endsection
