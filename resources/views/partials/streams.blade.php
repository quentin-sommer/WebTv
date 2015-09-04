<div class="thumbnail">
    <div class="caption streamerCaption">
        @if($streamer->isStreaming())
            <div data-toggle="tooltip" data-placement="top" title="En ligne" class="streaming btn-success">
            </div>
        @else
            <div data-toggle="tooltip" data-placement="top" title="Hors ligne" class="streaming btn-danger">
            </div>
        @endif
        <a href="{{route('getStream',['streamerName'=>$streamer->twitch_channel])}}">
            <h1 class="h4">{{$streamer->pseudo}}
                <small>({{$streamer->twitch_channel}})</small>
            </h1>
        </a>
    </div>
    <a href="{{route('getStream',['streamerName'=>$streamer->twitch_channel])}}">
        <img class="streamImg" src="{{Avatar::getUrl($streamer->avatar)}}" alt="image de profil"/>
    </a>

    <div class="caption">
        {{str_limit($streamer->description, 70)}}
    </div>
</div>