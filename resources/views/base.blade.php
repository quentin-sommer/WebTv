<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>WebTv - @yield('title')</title>
    <link rel="icon" href="{{ url('assets/images/favicon.ico') }}"/>
    <link rel="stylesheet" href="{{ url('assets/bootstrap-3.3.4/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('assets/bootstrap-toggle/css/bootstrap-toggle.min.css') }}"/>
    @yield('head')
    <style>
        .col-centered {
            float: none;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    @yield('content')
</div>
<footer>
    @yield('footer')
</footer>

<script type="text/javascript" src="{{url('assets/js/jquery.min.js')}}"></script>
<script src="{{ url('assets/bootstrap-3.3.4/js/bootstrap.min.js') }}"></script>
<script src="{{ url('assets/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
@yield('endBody')
<script>var isAdBlockActive = true;</script>
<script type="text/javascript" src="{{url('assets/js/ads.js')}}"></script>
<script type="text/javascript" src="{{url('assets/js/app.js')}}"></script>
</body>
</html>