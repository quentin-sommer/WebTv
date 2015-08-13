<div class="thumbnail">
    <div class="caption streamerCaption">
        <a href="{{route('getStream',['streamerName'=>$streamer->twitch_channel])}}">
            <h1 class="h4">{{$streamer->pseudo}} <small>({{$streamer->twitch_channel}})</small></h1>
        </a>
    </div>
    <a href="{{route('getStream',['streamerName'=>$streamer->twitch_channel])}}">
        <img class="streamImg" src="{{Avatar::getUrl($streamer->avatar)}}" alt="image de profil"/>
    </a>
</div>