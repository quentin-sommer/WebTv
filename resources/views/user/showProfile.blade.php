@extends('single')
@section('title','Profile')
@section('content')
    <div class="col-md-6 col-centered">

        <img class="img-responsive" style="margin: auto; display: block" src="{{Avatar::getUrl($user->avatar)}}" alt="image de profil"/>
        <p>Pseudo : {{$user->pseudo}}</p>
            @if($streamer)
                <p>Est un streamer, twitch : {{$user->twitch_channel}}</p>
            @else
                <p>N'est pas un streamer</p>
            @endif
        <p>Description : {{$user->description}}</p>
    </div>
@stop