@extends('single')
@section('title','Calendrier')
@section('head')
    @parent
    <link rel="stylesheet" href="{{url('assets/fullcalendar/fullcalendar.css')}}"/>
    <link rel="stylesheet" href="{{url('assets/bootstrap-datetimepicker/bootstrap-datetimepicker.min.css')}}"/>
@stop
@section('content')
    <div class="col-md-6 col-centered">
    <div id="calendar">

    </div>
        @if(Auth::check())
        @if(Auth::user()->isAdmin())
            @include('partials.newCalendarEvent')
        @endif
        @endif
    </div>
@stop
@section('endBody')
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
                eventResize: updateCal,
                eventRender: function(event, el) {
                    // render the timezone offset below the event title
                    if (event.start.hasZone()) {
                        el.find('.fc-title').after(
                                $('<div class="tzo"/>').text(event.start.format('Z'))
                        );
                    }
                }
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