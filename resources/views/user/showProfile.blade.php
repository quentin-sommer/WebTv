@extends('single')
@section('title','Profile')
@section('content')
    <div class="col-md-6 col-centered">

        <img class="img-responsive" style="margin: auto; display: block" src="{{Avatar::getUrl($user->avatar)}}" alt="image de profil"/>
        <h1>{{$user->pseudo}}</h1>
        @if($streamer)<p>(Streamer: {{$user->twitch_channel}})</p>@endif
        <h2>Description</h2>
        <blockquote>
           {{$user->description}}
        </blockquote>
    </div>
@stop