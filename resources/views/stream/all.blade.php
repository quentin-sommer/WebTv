@extends('single')
@section('title','Tous les streams')
@section('content')
    <style>
        .streams{
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .streams li {
            display: flex;
            flex-direction: column;
            flex-wrap: wrap;
        }
        .streams li p {
            text-align: center;
        }
        .streamImg {
            width: 200px;
        }
    </style>
    <ul class="streams">
    @foreach($streams as $streamer)
        <li>
            <p>{{$streamer->twitch_channel}}</p>
            <a href="{{route('getStream',['streamerName'=>$streamer->twitch_channel])}}">
                <img class="streamImg" src="{{Avatar::getUrl($streamer->avatar)}}" alt="image de profil"/>
            </a>
        </li>
    @endforeach
    </ul>
@stop