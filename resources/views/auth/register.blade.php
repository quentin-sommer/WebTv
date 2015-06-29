@extends('single')
@section('title','Inscription')
@section('content')
            <form action="{{route('postRegister')}}" method="post">
                <legend>Inscription</legend>
                <div class="form-group @if($errors->has('login')) has-error @endif">
                    <label for="login">Login</label>
                    <input type="text" class="form-control" placeholder="login" name="login" id="login"
                           value="{{old('login')}}"/>
                    @if ($errors->has('login'))
                        <p class="help-block">{{$errors->first('login')}}</p>
                    @endif
                </div>
                <div class="form-group @if($errors->has('email')) has-error @endif">
                    <label for="email">E-mail</label>
                    <input type="text" class="form-control" placeholder="e-mail" name="email" id="email"
                           value="{{old('email')}}"/>
                    @if ($errors->has('email'))
                        <p class="help-block">{{$errors->first('email')}}</p>
                    @endif
                </div>
                <div class="form-group @if($errors->has('password')) has-error @endif">
                    <label for="password">Mot de passe</label>
                    <input type="password" class="form-control" placeholder="mot de passe" name="password" id="password"
                           value="{{old('password')}}"/>
                    @if ($errors->has('password'))
                        <p class="help-block">{{$errors->first('password')}}</p>
                    @endif
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Confirmation</label>
                    <input type="password" class="form-control" placeholder="confirmation" name="password_confirmation"
                           id="password_confirmation"
                           value="{{old('password_confirmation')}}"/>
                </div>
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <button type="submit" class="btn btn-primary pull-right">Créer un compte</button>
            </form>
@stop
@section('footer')
@stop
@section('endBody')
@stop