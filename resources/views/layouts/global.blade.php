<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="_token" content="{{ csrf_token() }}">
    <title>@yield('title') | {{ s_get('shop.name', 'L-shop') }}</title>

    <link rel="stylesheet" href="css/app.min.css">
</head>

<body>
<div class="alerts"></div>

@yield('content_global')

<script src="js/app.min.js" type="text/javascript"></script>
</body>

</html>