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
            <nav>
                <ul class="nav navbar-nav">
                    <li><a href="{{route('getIndex')}}">Accueil</a></li>
                    <li><a href="{{route('streams')}}">Streams</a></li>
                    <li><a href="{{route('getCalendar')}}">Calendrier</a></li>
                    <li><a href="{{route('getProfile')}}">Profile</a></li>
                    <li><a href="{{route('getIndex')}}">About</a></li>
                    @if(Auth::check())
                        <li><a href="{{route('logout')}}">Se déconnecter</a></li>
                    @else
                        <li><a href="{{route('getLogin')}}">Se connecter</a></li>
                    @endif
                </ul>
            </nav>
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