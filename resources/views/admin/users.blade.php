@extends('singleBase')
@section('title','Admin - Users')
@section('head')
@stop
@section('content')
        <div class="col-md-12 col-centered">
            <form class="form-inline" action="{{route('getSearchUserSettings')}}" method="get">
                <div class="form-group">
                    <label for="login">Nom ou email</label>
                    <input type="text" class="form-control" name="login" id="login" placeholder="login/email" value="{{$user_search or ''}}">
                </div>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <button class="btn btn-primary" type="submit">
                    Filtrer
                </button>
            </form>

            @if(count($users) === 0)
                <h2>Aucun Utilisateur</h2>
            @else
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Login</th>
                        <th>Email</th>
                        <th>Twitch</th>
                        <th>Roles</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($users as $user)
                        <tr>
                            <th scope="row">
                                {{$user->user_id}}
                            </th>
                            <td>
                                {{$user->login}}
                            </td>
                            <td>
                                {{$user->email}}
                            </td>
                            <td>
                                {{$user->twitch_channel}}
                            </td>
                            <td>
                                <form id="{{$user->user_id}}" method="post" action="{{route('postUserSettings')}}">
                                    <input name="user_id" value="{{$user->user_id}}" type="hidden"/>
                                    <input name="login" value="{{$user->login}}" type="hidden"/>
                                    <input name="email" value="{{$user->email}}" type="hidden"/>
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                        @foreach($roles as $role)
                                            <label class="checkbox-inline" for="R{{$role->role_id}}">
                                                @if($user->roles->find($role->role_id))
                                                    <input data-toggle="toggle" name="roles[]"
                                                           value="{{$role->role_id}}"
                                                           checked="checked"
                                                           type="checkbox"
                                                           id="R{{$role->role_id}}"/>
                                                @else
                                                    <input data-toggle="toggle" name="roles[]"
                                                           value="{{$role->role_id}}"
                                                           type="checkbox"
                                                           id="R{{$role->role_id}}"/>
                                                @endif
                                                {{$role->title}}
                                            </label>
                                        @endforeach
                                </form>
                            </td>
                            <td>
                                <button form="{{$user->user_id}}" type="submit" class="btn btn-success">
                                    <span class="glyphicon glyphicon-ok"></span>
                                </button>
                                <form class="userAdminForm" action="{{route('postDeleteUser',['id' => $user->user_id ])}}" method="post">
                                    <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                                    <button class="btn btn-danger" type="submit">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {!!$users->render()!!}
            </div>
            @endif
        </div>
@stop
@section('footer')
@stop
@section('endBody')
@stop