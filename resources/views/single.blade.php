<!DOCTYPE html>
<html lang="fr" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>WebTv - @yield('title')</title>
    <link rel="icon" href="{{ url('assets/images/favicon.ico') }}"/>
    <link rel="stylesheet" href="{{ url('assets/bootstrap-3.3.4/css/bootstrap-theme.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('assets/bootstrap-3.3.4/css/bootstrap.min.css') }}"/>
    <link rel="stylesheet" href="{{ url('assets/bootstrap-toggle/css/bootstrap-toggle.min.css') }}"/>
    <link rel="stylesheet" href="{{url('assets/css/app.css')}}"/>
    <style>
        body {
            padding-top: 70px;
        }
    </style>
    @yield('head')
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Menu</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            @include('partials.menu')
            <form class="navbar-form" method="post" action="{{route('postStreamSearch')}}">
                <div class="form-group">
                    <input name="query" required="" autocomplete="off" type="text" class="form-control"
                           placeholder="Chercher un stream">
                </div>
                <div class="form-group">
                    <input data-toggle="toggle" name="all"
                           value="true"
                           type="checkbox"
                           id="streaming"/>
                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                <button type="submit" class="btn btn-default">Rechercher</button>
            </form>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>
@include('partials.errorDisplay')
<div class="container">
    <div class="col-md-12">
        @yield('content')
    </div>
</div>
<footer>
    @yield('footer')
</footer>

<script type="text/javascript" src="{{url('assets/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{ url('assets/bootstrap-3.3.4/js/bootstrap.min.js') }}"></script>
<script type="text/javascript" src="{{ url('assets/bootstrap-toggle/js/bootstrap-toggle.min.js') }}"></script>
@yield('endBody')
<script>var isAdBlockActive = true;</script>
<script type="text/javascript" src="{{url('assets/js/ads.js')}}"></script>
<script>
    if (isAdBlockActive) {
        // block the stream
        console.log("The visitor is blocking ads");
    }
</script>
</body>
</html>

