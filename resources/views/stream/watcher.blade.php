@extends('singleFluid')
@section('title',$streamer->twitch_channel)
@section('content')
    <div class="col-lg-12"  style="background-color: green;">
        Bandeau du stream
    </div>
    <h1 class="col-lg-12">
        <img class="thumbAvatar img-rounded" src="{{Avatar::getUrl($streamer->avatar)}}" alt="Image du stream">
        {{$streamer->pseudo}} <small>({{$streamer->twitch_channel}})</small>
    </h1>
            <div class="col-lg-8 col-md-9 col-sm-12">
                <object bgcolor="#000000"
                        data="//www-cdn.jtvnw.net/swflibs/TwitchPlayer.swf"
                        height="680"
                        type="application/x-shockwave-flash"
                        width="100%"
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
                           value="channel={{$streamer->twitch_channel}}&auto_play=true&start_volume=25" />
                </object>
                <p>Niveau : <span id="lvl"></span></p>
                <div class="progress">
                    <div id="progression" class="progress-bar" role="progressbar"
                         aria-valuenow=""
                         aria-valuemin="0"
                         aria-valuemax="100">
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-3 col-sm-12">
            <iframe frameborder="0"
                    scrolling="no"
                   id="chat_embed"
                    src="http://www.twitch.tv/{{$streamer->twitch_channel}}/chat"
                    height="680"
                    width="100%">
            </iframe>
            </div>
@stop

@section('endBody')
    <script type="text/javascript">
        var resyncAttemps = 0;
        $(function() {
            start();
        });
        function start() {
            var data = {
                streamer: '{{$streamer->twitch_channel}}',
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
            var $progression = $('#progression');
            $progression.html(data.progression + '%');
            $progression.attr('aria-valuenow', data.progression);
            $progression.width(data.progression+'%');

            window.setTimeout(function() {
                update(token);
            }, timerInMiliSec);
        }
        function update(token) {
            var data = {
                streamer: '{{$streamer->twitch_channel}}',
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
                    console.log('Error need resync');
                    if(resyncAttemps < 5) {
                        resyncAttemps ++;
                        start();
                    }
                    else {
                        return;
                    }
                }
            });
        }
    </script>
@stop