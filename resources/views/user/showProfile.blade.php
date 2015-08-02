@extends('single')
@section('title','Profile')
@section('content')
    <div class="col-md-6 col-centered">

        <img class="profilePic img-responsive" src="{{Avatar::getUrl($user->avatar)}}" alt="image de profil"/>
        <h1>{{$user->pseudo}}</h1>
        @if($streamer)<p>(Streamer: {{$user->twitch_channel}})</p>@endif
        <p>Niveau : {{$level}}</p>
        @if($editable)
        <p>Progression : {{$progression}}%</p>
        @endif
        <h2>Description</h2>
        <blockquote>
           {{$user->description}}
        </blockquote>
        @if($editable)
        <a href="{{route('getProfile')}}" class="btn btn-primary">Editer le profil</a>
        @endif
    </div>
@stop