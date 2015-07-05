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

