@extends('singleBase')
@section('title','Profile')
@section('content')
    <div class="col-md-6 col-centered">
        <form autocomplete="off" action="{{route('postProfile')}}" method="post" enctype="multipart/form-data">
            <legend>Editer les informations</legend>
            <div class="form-group text-center">
                <img class="profilePic img-responsive" src="{{Avatar::getUrl($user->avatar)}}" alt="image de profil"/>
                @if(Avatar::isNotDefault($user->avatar))
                    <a class="btn btn-danger" href="{{route('deleteAvatar')}}">Supprimer</a>
                @endif
            </div>
            <div class="form-group @if($errors->has('profilePic')) has-error @endif">
                <label class="control-label" for="profilePic">Changer l'image de profil</label>
                <input class="btn btn-default" type="file" placeholder="Image de profil" name="profilePic" id="profilePic"/>
                @if ($errors->has('profilePic'))
                    <p class="help-block">{{$errors->first('profilePic')}}</p>
                @endif
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
            @if($streamer)
                <div class="form-group @if($errors->has('twitch')) has-error @endif">
                    <label class="control-label" for="twitch">Twitch channel</label>
                    <input autocomplete="off" type="text" class="form-control" placeholder="Twitch channel" name="twitch" id="twitch"
                           value="{{$user->twitch_channel}}"/>
                    @if ($errors->has('twitch'))
                        <p class="help-block">{{$errors->first('twitch')}}</p>
                    @endif
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
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <button type="submit" class="btn btn-primary pull-right">Sauvegarder</button>
        </form>
    </div>
@stop