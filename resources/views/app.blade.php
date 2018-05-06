<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="{{ $description }}">
    <meta name="keywords" content="{{ $keywords }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title }}</title>

    <link href="{{ asset('fonts.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.min.css') }}" type="text/css" rel="stylesheet">

    <script src='https://www.google.com/recaptcha/api.js' type="text/javascript" async defer></script>
</head>
<body>

<div id="app">
    <v-app>
        <notifications></notifications>
        <request-error></request-error>
        <preloader></preloader>

        <router-view></router-view>
    </v-app>
</div>

<script src="{{ route('frontend.lang.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/app.min.js') }}" type="text/javascript"></script>

</body>
</html>
