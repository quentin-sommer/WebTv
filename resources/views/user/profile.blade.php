@extends('single')
@section('title','Profile')
@section('content')
    <div class="col-md-6 col-centered">
        <form action="{{route('postProfile')}}" method="post" enctype="multipart/form-data">
            <legend>Editer les informations</legend>
        <div>
            <img src="{{Avatar::getUrl($user->avatar)}}" alt="image de profil"/>
            @if(Avatar::isNotDefault($user->avatar))
                <a href="{{route('deleteAvatar')}}">Supprimer</a>
            @endif
        </div>

            <div class="form-group @if($errors->has('profilePic')) has-error @endif">
                <label for="profilePic">Changer l'image de profil</label>
                <input type="file" placeholder="Image de profil" name="profilePic" id="profilePic"/>
                @if ($errors->has('profilePic'))
                    <p class="help-block">{{$errors->first('profilePic')}}</p>
                @endif
            </div>
            <div class="form-group @if($errors->has('email')) has-error @endif">
                <label for="email">E-mail</label>
                <input autocomplete="off" type="text" class="form-control" placeholder="e-mail" name="email" id="email"
                       value="{{$user->email}}"/>
                @if ($errors->has('email'))
                    <p class="help-block">{{$errors->first('email')}}</p>
                @endif
            </div>
            @if($streamer)
                <div class="form-group @if($errors->has('twitch')) has-error @endif">
                    <label for="twitch">Twitch channel</label>
                    <input autocomplete="off" type="text" class="form-control" placeholder="Twitch channel" name="twitch" id="twitch"
                           value="{{$user->twitch_channel}}"/>
                    @if ($errors->has('twitch'))
                        <p class="help-block">{{$errors->first('twitch')}}</p>
                    @endif
                </div>
            {{dump($user->isStreaming())}}
            {{dump($user->streaming)}}
                <div class="form-group">
                    <label for="streaming">
                        <input data-toggle="toggle" name="streaming"
                               value="1"
                               @if($user->isStreaming()) checked="checked" @endif
                               type="checkbox"
                               id="streaming"/>
                        En train de streamer
                    </label>
                </div>
            @endif
            <div class="form-group @if($errors->has('password')) has-error @endif">
                <label for="password">Changer le mot de passe</label>
                <input autocomplete="off" type="password" class="form-control" placeholder="mot de passe" name="password" id="password"
                       value="{{old('password')}}"/>
                @if ($errors->has('password'))
                    <p class="help-block">{{$errors->first('password')}}</p>
                @endif
            </div>
            <div class="form-group">
                <label for="password_confirmation">Confirmation</label>
                <input autocomplete="off" type="password" class="form-control" placeholder="confirmation" name="password_confirmation"
                       id="password_confirmation"
                       value="{{old('password_confirmation')}}"/>
            </div>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <button type="submit" class="btn btn-primary pull-right">Sauvegarder</button>
        </form>
    </div>
@stop