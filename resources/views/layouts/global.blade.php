{{-- Layout and design by WhileD0S <https://vk.com/whiled0s>  --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ s_get('shop.name', 'L-shop') }}</title>

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

@yield('content_global')

<script src="{{ asset('js/app.min.js') }}" type="text/javascript"></script>

@include('components.messages')

</body>
</html>