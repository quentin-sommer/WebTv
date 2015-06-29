@extends('single')
@section('title','Login')
@section('content')
            <form action="{{route('postLogin')}}" method="post">
                <legend>Connexion</legend>

                <div class="form-group @if($errors->has('login')) has-error @endif">
                    <label for="login">Login</label>
                    <input type="text" class="form-control" placeholder="login" name="login" id="login"
                           value="{{old('login')}}"/>
                    @if ($errors->has('login'))
                        <p class="help-block">{{$errors->first('login')}}</p>
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
                    <label class="checkbox-inline" for="remember">
                        <input type="checkbox" name="remember" value="true" id="remember"/>Rester connecter
                    </label>
                </div>
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="submit" class="btn btn-primary pull-right">Se connecter</button>
            </form>
@stop
@section('footer')
@stop
@section('endBody')
@stop