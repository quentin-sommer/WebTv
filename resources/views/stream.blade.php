@extends('single')
@section('title',$streamingUser->twitch_channel)
@section('content')
            <!--<div class="col-md-9">
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
                </object> -->
                <p>Niveau : <span id="lvl"></span></p>
                <p>Progression : <span id="progression"></span></p>
            </div>
            <div class="col-md-3">
            <!--<iframe frameborder="0"
                    scrolling="no"
                    id="chat_embed"
                    src="http://www.twitch.tv/{{$streamingUser->twitch_channel}}/chat"
                    height="480"
                    width="400">
            </iframe>-->
            </div>
@stop
@section('endBody')
    <script type="text/javascript">
        $(function() {
            start();
        });
        function start() {
            var data = {
                streamer: '{{$streamingUser->twitch_channel}}',
                _token: '{{csrf_token()}}'
            };
            $.ajax({
                type: 'POST',
                url: '{{route('startWatching')}}',
                data: data,
                success: function (data) {
                    loop(data);
                },
                error: function (data, status) {
                    // either no streaming occuring with that name
                    // or no streamer name input
                }
            });
        }
        function loop(data) {
            var token = data.token;
            var timerInMn = data.nextXpRequest;
            var timerInMiliSec = timerInMn * 60000;
            $('#lvl').html(data.level);
            $('#progression').html(data.progression + '%');

            window.setTimeout(function() {
                update(token);
            }, timerInMiliSec);
        }
        function update(token) {
            var data = {
                streamer: '{{$streamingUser->twitch_channel}}',
                token: token,
                _token: '{{csrf_token()}}'
            };
            $.ajax({
                type: 'POST',
                url: '{{route('updateWatching')}}',
                data: data,
                success: function (data) {
                    start();
                },
                error: function (data, status) {
                }
            });
        }
    </script>
@stop