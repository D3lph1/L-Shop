<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ $title }}</title>

    <link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('css/app.min.css') }}">

    <script src='https://www.google.com/recaptcha/api.js' type="text/javascript"></script>
</head>
<body>

<div id="pre-loader">
    <div id="pre-animation">
        <span><i class="fa fa-spin fa-cog"></i></span>
    </div>
</div>
<div class="messages"></div>

<div id="app">
    @yield('global')
</div>

<script src="{{ route('frontend.lang.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/preloader.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/app.min.js') }}" type="text/javascript"></script>
@include('components.notifications')
</body>
</html>
