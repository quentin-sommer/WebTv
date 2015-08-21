@extends('singleBase')
@section('title','Tous les streams')
@section('content')
    <ul class="streams">
        @foreach($streams as $streamer)
            <li class="col-lg-3 col-md-3 col-sm-4 col-xs-6">
                @include('partials.streams')
            </li>
        @endforeach
    </ul>
@stop