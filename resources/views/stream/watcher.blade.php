@extends('singleFluidBase')
@section('title',$streamer->twitch_channel)
@section('content')
    <div class="col-lg-12">
        <img class="img-responsive" src="{{StreamBanner::getUrl($streamer->stream_banner)}}" alt="">

        <h1 class="streamHeader">
                <img class="thumbAvatar img-rounded" src="{{Avatar::getUrl($streamer->avatar)}}" alt="Image du stream">

            <a href="{{route('showProfile', ['user' => $streamer->pseudo])}}">
                {{$streamer->pseudo}}
            </a>
            <small>({{$streamer->twitch_channel}})</small>
        </h1>
    </div>
            <div class="col-lg-8 col-md-9 col-sm-12 twitchStream">
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
                @if(Auth::check())
                <p>Niveau : <span id="lvl"></span></p>
                <div class="progress">
                    <div id="progression" class="progress-bar" role="progressbar"
                         aria-valuenow=""
                         aria-valuemin="0"
                         aria-valuemax="100">
                    </div>
                </div>
                @else
                    <p><a href="{{route('getLogin')}}">Connectez vous</a> ou <a href="{{route('getRegister')}}">créez un compte</a> pour gagner de l'experience</p>
                    <p>Niveau : <span id="lvl">1</span></p>
                    <div class="progress progress-bar-striped">
                        <div style="width: 0%;" id="progression" class="progress-bar" role="progressbar"
                             aria-valuenow="0"
                             aria-valuemin="0"
                             aria-valuemax="100">
                        </div>
                        0%
                    </div>
                @endif
            </div>
            <div class="col-lg-4 col-md-3 col-sm-12 twitchChat">
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
            if(adsAreBlocked()) {
                $('.twitchStream').replaceWith(
                        '<div class="col-lg-12">' +
                            '<div class="jumbotron adBlockOverlay">' +
                                '<h1 class="adBlockOverlayMessage">AdBlock tue les streamers. <small>(Vraiment)</small></h1>'+
                                '<p>L\'extension AdBlock bloque les publicités de twitch qui permettent aux streamers de vivre.</p>'+
                                '<p>Pour visionner le stream nous vous invitons a désactiver votre bloqueur et <a href="{{Request::url()}}">rafraichir la page</a></p>'+
                            '</div>' +
                        '</div>'
                );
                $('.twitchChat').remove();
            }
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