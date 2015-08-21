@extends('base')
@section('title','Accueil')
@section('head')
    @parent
    <link rel="stylesheet" href="{{ url('assets/css/font-awesome.min.css')}}"/>

    <link rel="stylesheet" href="{{ url('assets/css/plugins.css') }}"/>
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}"/>

    <link rel="stylesheet" href="{{url('assets/fullcalendar/fullcalendar.css')}}"/>
@stop
@section('content')
        <!--Loader-->
    <div class="loader-holder">
        <div class="loader">
            <div id="movingBallG">
                <div class="movingBallLineG"></div>
                <div id="movingBallG_1" class="movingBallG"></div>
            </div>
        </div>
    </div>
    <!--Loader end -->
    <!--================= main start ================-->
    <div id="main">
        <div id="fall-holder"></div>
        <!--================= menu ================-->
        <div class="nav-button">
            <span  class="nos"></span>
            <span class="ncs"></span>
            <span class="nbs"></span>
        </div>
        <div id="nav" class="vis elem">
            <div id="menu" class="elem-anim">
                <a>Calendrier<span class="transition"></span></a>
                <a data-page="0" class="active">Accueil <span class="transition"></span></a>
                <a>Streams <span class="transition"></span></a>
                <a>A propos <span class="transition"></span></a>
            </div>
        </div>
        <!--Navigation end-->
        <!--================= Subscribe  ================-->
        @if(Auth::guest())
        <div class="subcribe-form-holder elem">
            <div class="subcribe-form elem-anim">
                <form id="subscribe" action="{{route('postLogin')}}" method="post">
                    <input class="enteremail" name="login" placeholder="Login" type="text">
                    <input class="enteremail" type="password" name="password" placeholder="Mot de passe"/>
                    <input type="hidden" name="_token" value="{{csrf_token()}}"/>
                        <button class="btn btn-default" type="submit">Login</button>
                        <a class="btn btn-default" href="{{route('getRegister')}}">Inscription</a>
                </form>
            </div>
        </div>
        @endif()

        <!--Subscribe end-->
        <!--================= Social links  ================-->
        <div class="social-links elem">
            <ul class="elem-anim">
                <li><a href="#" target="_blank" class="transition">
                        <i class="fa fa-facebook"></i>
                        <span class="tooltip">Facebook</span>
                    </a>
                </li>
                <li><a href="#" target="_blank" class="transition">
                        <i class="fa fa-twitter"></i>
                        <span class="tooltip">Twitter</span>
                    </a>
                </li>
            </ul>
        </div>
        <!--Social links  end-->
        <!--================= Wrapper start  ================-->
        <div class="wrapper transition">
            <!--================= arrow  navigation ================-->
            <a href="#" class="arrow-right transition2"><i class="fa fa-angle-right"></i></a>
            <a href="#" class="arrow-left transition2"><i class="fa fa-angle-left"></i></a>
            <!--start content-->
            <div class="swiper-container">
                <div class="swiper-wrapper">
                    <!--============= Calendar section =============-->
                    <div class="swiper-slide slide-bg" style="background:url({{url('assets/images/bg/1.jpg')}})">
                        <div class="overlay hmoov"></div>
                        <div class="container">
                            <section>
                                <div class="content-inner">
                                    <div class="section-decor"></div>
                                    <div class="content-holder">
                                        <div id="calendar">
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <!--Calendar  end-->
                    <!--================= Home section ================-->
                    <div class="swiper-slide slide-bg" style="background:url({{url('assets/images/bg/1.jpg')}})">
                        <div class="media-container">
                            <!-- Youtube  bg-->
                            <div class="video-holder">
                                <div id="player"></div>
                            </div>
                        </div>
                        <div class="overlay hmoov"></div>
                        <div class="container">
                            <div id="canvas-holder">
                                <canvas id="demo-canvas"></canvas>
                            </div>
                            <div class="logo">
                                <img src="{{url('assets/images/logo2.png')}}" alt="">
                            </div>
                            <div class="counter-content">
                                <ul class="countdown">
                                    <li>
                                        <span class="days rot">00</span>

                                        <p>days</p>
                                    </li>
                                    <li>
                                        <span class="hours rot">00</span>

                                        <p>hours </p>
                                    </li>
                                    <li>
                                        <span class="minutes rot2">00</span>

                                        <p>minutes </p>
                                    </li>
                                    <li>
                                        <span class="seconds rot2">00</span>

                                        <p>seconds</p>
                                    </li>
                                </ul>
                            </div>
                            <div class="hero-text">
                                <h2>Beta coming soon </h2>
                            </div>
                        </div>
                    </div>
                    <!--home end-->
                    <!-- Stream Section -->
                    <div class="swiper-slide slide-bg" style="background:url({{url('assets/images/bg/1.jpg')}})">
                        <div class="overlay hmoov"></div>
                        <div class="container">
                            <section>
                                <div class="content-inner">
                                    <div class="section-decor">

                                    </div>
                                    <div class="">
                                    <ul class="streams">
                                        @foreach($streams as $streamer)
                                            <li class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
                                                @include('partials.streams')
                                            </li>
                                        @endforeach
                                    </ul>
                                    </div>
                                </div>
                            </section>

                        </div>
                    </div>
                    <!-- Stream end -->
                    <!--============= about section =============-->
                    <div class="swiper-slide slide-bg" style="background:url({{url('assets/images/bg/1.jpg')}})">
                        <div class="overlay hmoov"></div>
                        <div class="container">
                            <section>
                                <div class="content-inner">
                                    <div class="section-decor">

                                    </div>
                                    <div class="content-holder">
                                        <div class="about">
                                            <h3>A Propos</h3>
                                            <h4>Sous titre a propos</h4>

                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod</p>


                                        </div>
                                        <div class="btn go-contact">Our contacts</div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                    <!--about end-->
                </div>
            </div>
        </div>
        <!--Wrapper  end -->
    </div>
    <!--Main  end --> @stop
@section('footer')
@stop
@section('endBody')
    <script type="text/javascript" src="{{url('assets/js/plugins.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/scripts.js')}}"></script>
    <script type="text/javascript">
        var tag = document.createElement('script');
        tag.src = "//www.youtube.com/player_api";
        var firstScriptTag = document.getElementsByTagName('script')[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

        var player;
        var vstring = 'lJJ9TcGxhNY';
        function onYouTubePlayerAPIReady() {
            player = new YT.Player('player', {
                playerVars: {'autoplay': 1, 'loop': 1, 'playlist': vstring, 'controls': 0, 'showinfo': 0},

                videoId: vstring,
                events: {
                    'onReady': onPlayerReady
                }
            });
        }
        function onPlayerReady(event) {
            event.target.setVolume(0);
            event.target.mute();
            event.target.playVideo();
            event.target.setPlaybackQuality('hd720');
        }
    </script>
    <script type="text/javascript" src="{{url('assets/moment/moment-with-locales.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/fullcalendar/fullcalendar.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/fullcalendar/lang/fr.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/bootstrap-datetimepicker/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript">
        $(function() {
            $('#calendar').fullCalendar({
                lang: 'fr',
                defaultView: 'agendaWeek',
                aspectRatio: 1,
                allDayDefault: false,
                allDaySlot: false,
                timezone: 'local',
                @if(Auth::check())
                    @if(Auth::user()->isAdmin())
                    editable: true,
                @endif
                @else
                editable: false,
                @endif
                events:'{{route('getCalEvents')}}',
                eventDrop: updateCal,
                eventResize: updateCal
            });
            function updateCal(event, delta, revertFunc) {
                var data = {
                    id : event.id,
                    allDay: /*event.allDay*/ false,
                    start: event.start.format('YYYY-MM-DD HH:mm:ss'),
                    end: event.end.format('YYYY-MM-DD HH:mm:ss'),
                    title: event.title,
                    color: event.color,
                    _token: '{{csrf_token()}}'
                };
                $.ajax({
                    type: 'POST',
                    url: '{{route('calendarEdit')}}',
                    data: data,
                    success: function () {
                        console.log('success');
                    },
                    error: function () {
                        alert('Erreur technique, annulation...');
                        revertFunc();
                    }
                });
            }
        });
    </script>
    <script type="text/javascript">
        $(function () {
            $('#startPicker').datetimepicker({
                format:'YYYY-MM-DD HH:mm:ss'
            });
            $('#endPicker').datetimepicker({
                format:'YYYY-MM-DD HH:mm:ss'
            });

            $("#startPicker").on("dp.change", function (e) {
                $('#timezoneInput').val(e.date.format('Z'));
            });
        });
    </script>
@stop