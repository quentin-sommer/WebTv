@extends('single')
@section('title','Tous les streams')
@section('content')
    <ul class="streams">
    @foreach($streams as $streamer)
        <li class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
            <p>{{$streamer->twitch_channel}}</p>
            <a href="{{route('getStream',['streamerName'=>$streamer->twitch_channel])}}">
                <img class="streamImg" src="{{Avatar::getUrl($streamer->avatar)}}" alt="image de profil"/>
            </a>
        </li>
    @endforeach
    </ul>
@stop