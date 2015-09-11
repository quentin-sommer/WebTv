@extends('singleBase')
@section('title','Profile')
@section('head')
    <link rel="stylesheet" href="{{ url('assets/')}}"/>
@stop
@section('content')
    <div class="col-md-6 col-centered">
        <form autocomplete="off" action="{{route('postProfile')}}" method="post" enctype="multipart/form-data">
            <legend>Editer les informations</legend>
            <div class="form-group">
                <img class="pic profilePic img-responsive" src="{{Avatar::getUrl($user->avatar)}}" alt="avatar">
                <div class="controlButtons text-center">
                    <a data-toggle="modal" data-target="#profilePicCropper" class="btn btn-primary" href="">Modifier</a>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label">Login</label>
                <input autocomplete="off" disabled="" type="text" class="form-control"
                       value="{{$user->login}}"/>
            </div>
            <div class="form-group">
                <label class="control-label">Pseudo</label>
                <input autocomplete="off" disabled="" type="text" class="form-control"
                       value="{{$user->pseudo}}"/>
            </div>
            <div class="form-group @if($errors->has('email')) has-error @endif">
                <label class="control-label" for="email">E-mail</label>
                <input autocomplete="off" type="text" class="form-control" placeholder="e-mail" name="email" id="email"
                       value="{{$user->email}}"/>
                @if ($errors->has('email'))
                    <p class="help-block">{{$errors->first('email')}}</p>
                @endif
            </div>

            <div class="form-group @if($errors->has('password')) has-error @endif">
                <label class="control-label" for="password">Changer le mot de passe</label>
                <input autocomplete="off" type="password" class="form-control" placeholder="mot de passe" name="password" id="password"
                       value="{{old('password')}}"/>
                @if ($errors->has('password'))
                    <p class="help-block">{{$errors->first('password')}}</p>
                @endif
            </div>
            <div class="form-group">
                <label class="control-label" for="password_confirmation">Confirmation</label>
                <input autocomplete="off" type="password" class="form-control" placeholder="confirmation" name="password_confirmation"
                       id="password_confirmation"
                       value="{{old('password_confirmation')}}"/>
            </div>
            <div class="form-group @if($errors->has('description')) has-error @endif">
                <label class="control-label" for="description">Description</label>
                <textarea class="form-control" name="description" id="description" cols="30" rows="5">{{$user->description}}</textarea>
                @if ($errors->has('description'))
                    <p class="help-block">{{$errors->first('description')}}</p>
                @endif
            </div>

            @if($streamer)
                <h1>Réglages streamer</h1>
                <div class="form-group @if($errors->has('twitch')) has-error @endif">
                    <label class="control-label" for="twitch">Twitch channel</label>
                    <input autocomplete="off" type="text" class="form-control" placeholder="Twitch channel" name="twitch" id="twitch"
                           value="{{$user->twitch_channel}}"/>
                    @if ($errors->has('twitch'))
                        <p class="help-block">{{$errors->first('twitch')}}</p>
                    @endif
                </div>

                <div class="form-group">
                    <label class="control-label" for="streamBanner">Changer le bandeau du stream</label>
                        <img id="debug" class="img-responsive" src="{{StreamBanner::getUrl($user->stream_banner)}}" alt="image du stream"/>
                        <div class="controlButtons text-center">
                            <a data-toggle="modal" data-target="#streamBannerCropper" class="btn btn-primary" href="">Modifier</a>
                        </div>
                </div>

                <div class="form-group">
                    <label class="control-label" for="streaming">
                        <input data-toggle="toggle" name="streaming"
                               value="1"
                               @if($user->isStreaming()) checked="checked" @endif
                               type="checkbox"
                               id="streaming"/>
                        En train de streamer
                    </label>
                </div>
            @endif

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <button type="submit" class="btn btn-primary pull-right">Sauvegarder</button>
        </form>
    </div>
    <!-- ----------------------------- MODALS ----------------------- -->
    <div class="modal fade" id="profilePicCropper">
        <div class="modal-dialog modal-lg stream-cropit">
            <div class="modal-content">
                <div class="stream-cropit modal-body">
                    <!-- This wraps the whole cropper -->
                    <div id="profile-cropit">

                        <div class="cropit-image-preview-container">
                            <!-- Background image container is absolute positioned -->
                            <div class="cropit-image-background-container">
                                <!-- Background image is absolute positioned -->
                                <img class="cropit-image-background" />
                            </div>
                            <div class="cropit-image-preview profilePic"></div>
                        </div>

                        <div class="controlButtons text-center">
                            <!-- This range input controls zoom -->
                            <!-- You can add additional elements here, e.g. the image icons -->
                            <div class="slider-wrapper">
                                <span class="glyphicon glyphicon-picture imgIconSmall"></span>
                                <input type="range" class="cropit-image-zoom-input zoomSlider" min="0" max="1" step="0.01"/>
                                <span class="glyphicon glyphicon-picture imgIconBig"></span>
                            </div>
                            @if(Avatar::isNotDefault($user->avatar))
                                <a class="btn btn-danger" href="{{route('deleteAvatar')}}">Supprimer</a>
                            @endif
                            <button class="btn btn-primary newProfilePicBtn">Changer l'image</button>
                            <input class="cropit-image-input" type="file" id="profilePicInput"/>
                        </div>
                    </div>
                </div>
                <div class="modal-body pull-right">
                    <button data-dismiss="modal" class="btn btn-default">Annuler</button>
                    <button class="btn btn-primary uploadProfilePic">Uploader</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="streamBannerCropper">
        <div class="modal-dialog modal-huge stream-cropit">
            <div class="modal-content">
                <div class="stream-cropit modal-body">
                    <!-- This wraps the whole cropper -->
                    <div id="streamBanner-cropit">

                        <div class="cropit-image-preview-container">
                            <!-- Background image container is absolute positioned -->
                            <div class="cropit-image-background-container">
                                <!-- Background image is absolute positioned -->
                                <img class="cropit-image-background" />
                            </div>
                            <div class="cropit-image-preview streamBanner"></div>
                        </div>
                        <div class="controlButtons text-center">
                            <!-- This range input controls zoom -->
                            <!-- You can add additional elements here, e.g. the image icons -->
                            <div class="slider-wrapper">
                                <span class="glyphicon glyphicon-picture imgIconSmall"></span>
                                <input type="range" class="cropit-image-zoom-input zoomSlider" min="0" max="1" step="0.01"/>
                                <span class="glyphicon glyphicon-picture imgIconBig"></span>
                            </div>
                            @if(StreamBanner::isNotDefault($user->stream_banner))
                                <a class="btn btn-danger" href="{{route('deleteStreamBanner')}}">Supprimer</a>
                                @endif
                                        <!-- This is where user selects new image -->
                                <button class="btn btn-primary newStreamBannerPicBtn">Changer l'image</button>
                                <input class="cropit-image-input" type="file" id="streamBannerPicInput"/>
                        </div>
                    </div>
                </div>
                <div class="modal-body pull-right">
                    <button data-dismiss="modal" class="btn btn-default">Annuler</button>
                    <button class="btn btn-primary uploadStreamBannerPic">Uploader</button>
                </div>
            </div>
        </div>
    </div>
@stop
@section('endBody')
    <script type="text/javascript" src="{{url('assets/cropit/cropit.js')}}"></script>
    <script>

        $(function() {
            var $profileCropit;
            $profileCropit = $('#profile-cropit').cropit(
                    {
                        @if(Avatar::isNotDefault($user->avatar))
                        imageState : {
                            src: '{{Avatar::getUrl($user->avatar)}}'
                        },
                        @endif
                        onImageLoaded: function () {
                            $('.uploadProfilePic').css('display','inline-block');
                        },
                        initialZoom:'image'
                    }
            );
            var $streamCropit;
            $streamCropit = $('#streamBanner-cropit').cropit(
                    {
                        @if(StreamBanner::isNotDefault($user->stream_banner))
                        imageState : {
                            src: '{{StreamBanner::getUrl($user->stream_banner)}}'
                        },
                        @endif
                        onImageLoaded: function () {
                            $('.uploadStreamBannerPic').css('display','inline-block');
                        },
                        initialZoom:'image'
                    }
            );

            $('.newProfilePicBtn').click(function() {
                $('#profilePicInput').click();
            });
            $('.newStreamBannerPicBtn').click(function() {
                $('#streamBannerPicInput').click();
            });

            $('.uploadProfilePic').click(function (e) {
                $(this).prop("disabled",true).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Upload...');
                var data = {
                    profilePicInput : $profileCropit.cropit('export'),
                    _token: '{{csrf_token()}}'
                };
                $.ajax({
                    method: "POST",
                    url: "{{route('avatarUpload')}}",
                    data: data,
                    success:function(data) {
                        location.reload();
                    },
                    error: function () {
                        location.reload();
                        console.log('error');
                    }
                });
                e.preventDefault();
            });
            $('.uploadStreamBannerPic').click(function(e) {
                $(this).prop("disabled",true).html('<span class="glyphicon glyphicon-refresh glyphicon-refresh-animate"></span> Upload...');
                var data = {
                    streamBannerPicInput : $streamCropit.cropit('export'),
                    _token: '{{csrf_token()}}'
                };
                $.ajax({
                    method: "POST",
                    url: "{{route('streamBannerUpload')}}",
                    data: data,
                    success:function(data) {
                      location.reload();
                    },
                    error: function () {
                        location.reload();
                        console.log('error');
                    }
                });
                e.preventDefault();
            });
        });
    </script>
@stop