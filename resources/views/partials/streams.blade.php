<div class="thumbnail">
    <div class="caption streamerCaption">
        <h1 class="h5">{{$streamer->twitch_channel}}</h1>
    </div>
    <a href="{{route('getStream',['streamerName'=>$streamer->twitch_channel])}}">
        <img class="streamImg" src="{{Avatar::getUrl($streamer->avatar)}}" alt="image de profil"/>
    </a>
</div>