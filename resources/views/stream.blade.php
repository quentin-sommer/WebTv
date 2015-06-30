@extends('single')
@section('title',$streamingUser->twitch_channel)
@section('content')
            <div class="col-md-9">
                <object bgcolor="#000000"
                        data="//www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf"
                        height="480"
                        type="application/x-shockwave-flash"
                        width="854"
                        >
                    <param name="allowFullScreen"
                           value="true" />
                    <param name="allowNetworking"
                           value="all" />
                    <param name="allowScriptAccess"
                           value="always" />
                    <param name="movie"
                           value="//www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf" />
                    <param name="flashvars"
                           value="channel={{$streamingUser->twitch_channel}}&auto_play=true&start_volume=25" />
                </object>
            </div>
            <div class="col-md-3">
            <iframe frameborder="0"
                    scrolling="no"
                    id="chat_embed"
                    src="http://www.twitch.tv/{{$streamingUser->twitch_channel}}/chat"
                    height="480"
                    width="400">
            </iframe>
            </div>
@stop