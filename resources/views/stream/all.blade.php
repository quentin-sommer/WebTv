@extends('single')
@section('title','Tous les streams')
@section('content')
    <style>
        .streams{
            display: flex;
            flex-wrap: wrap;
        }
        .streams li {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
        }
        .streamImg {
            width: 200px;
        }
    </style>
    <ul class="streams">
    @foreach($streams as $streamer)
        <li>
            <a href="{{route('getStream',['streamerName'=>$streamer->twitch_channel])}}">
                {{$streamer->twitch_channel}}
            </a>
            <img class="streamImg" src="{{Avatar::getUrl($streamer->avatar)}}" alt="image de profil"/>
        </li>
    @endforeach
    </ul>
@stop