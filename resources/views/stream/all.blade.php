@extends('single')
@section('title','Tous les streams')
@section('content')
    <ul>
    @foreach($streams as $streamer)
        <li>
            <img src="{{Avatar::getUrl($streamer->avatar)}}" alt="image de profil"/>
            <a href="{{route('getStream',['streamerName'=>$streamer->twitch_channel])}}">
                {{$streamer->twitch_channel}}
            </a>
        </li>
    @endforeach
    </ul>
@stop