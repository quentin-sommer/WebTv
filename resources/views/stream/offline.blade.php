@extends('singleBase')
@section('title','Hors ligne')
@section('content')
    <div class="col-lg-12"> 
        <div class="jumbotron jumbotronOverlay">
            <h1 class="adBlockOverlayMessage"><a href="{{route('showProfile',['user' => $streamer->pseudo])}}">{{$streamer->twitch_channel}}</a> <small>est hors ligne.</small></h1>
            <p><a href="{{Request::url()}}">rafraîchir la page</a></p>
            </div> 
        </div>
@stop