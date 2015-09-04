<?php
/**
 * Created by PhpStorm.
 * User: Quentin
 * Date: 26/06/2015
 * Time: 23:08
 */

namespace app\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Request as Request;
use Illuminate\Support\Facades\Validator;
use Laravel\Lumen\Routing\Controller as BaseController;
use Models\Event;

class CalendarController extends BaseController
{
    public function getCalendar()
    {
        return view('calendar');
    }

    public function addEvent()
    {

        $validator = Validator::make(Request::all(), [
            'title'    => 'required',
            'start'    => 'required|date_format:Y-m-d H:i:s',
            'end'      => 'required|date_format:Y-m-d H:i:s',
            'color'    => 'required',
            'timezone' => 'required'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator->errors())
                ->withInput();
        }
        $event = new Event();
        $event->title = Request::input('title');
        $event->start = Request::input('start');
        $event->end = Request::input('end');
        $event->color = Request::input('color');
        $event->timezone = Request::input('timezone');
        $event->allDay = false;
        $event->save();

        return redirect(route('getCalendar'));
    }

    public function getCalEvents()
    {
        $start = Carbon::createFromFormat('Y-m-d', Request::input('start'));
        $end = Carbon::createFromFormat('Y-m-d', Request::input('end'));

        $formatData = Event::where('start', '>', $start->toDateString())
            ->where('end', '<', $end->toDateString())->get()
            ->map(function ($item) {
                return [
                    'id'    => $item->event_id,
                    'title' => $item->title,
                    'start' => str_replace(' ', 'T', $item->start) . $item->timezone,
                    'end'   => str_replace(' ', 'T', $item->end) . $item->timezone,
                    'color' => $item->color
                ];
            });

        return response()->json($formatData);
    }

    public function editCalendar()
    {
        $validator = Validator::make(Request::all(), [
            'id'     => 'required',
            'allDay' => 'required',
            'start'  => 'required|date_format:Y-m-d H:i:s',
            'end'    => 'required|date_format:Y-m-d H:i:s',
            'title'  => 'required',
            'color'  => 'required'
        ]);

        if ($validator->fails()) {
            return new JsonResponse($validator->errors(), 422);
        }
        $event = Event::find(Request::input('id'));

        $event->title = Request::input('title');
        $event->start = Request::input('start');
        $event->end = Request::input('end');
        $event->allDay = Request::input('allDay');
        $event->color = Request::input('color');
        $event->save();

        return new JsonResponse(Event::all());
    }
}