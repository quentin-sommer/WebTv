@extends('single')
@section('title','Calendrier')
@section('head')
    @parent
    <link rel="stylesheet" href="{{ url('assets/fullcalendar/fullcalendar.css') }}"/>
@stop
@section('content')
    <div id="calendar"></div>
@stop
@section('endBody')
    <script type="text/javascript" src="{{url('assets/fullcalendar/lib/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/fullcalendar/fullcalendar.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/fullcalendar/lang/fr.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#calendar').fullCalendar({
                lang: 'fr',
                defaultView: 'agendaWeek',
                aspectRatio: 1,
                allDayDefault: false,
                allDaySlot: false,
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
            })
            function updateCal(event, delta, revertFunc) {
                var data = {
                    id : event.id,
                    allDay: /*event.allDay*/ false,
                    start: event.start.format('YYYY-MM-DD hh:mm:ss'),
                    end: event.end.format('YYYY-MM-DD hh:mm:ss'),
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
@stop

