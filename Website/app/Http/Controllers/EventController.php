<?php

namespace PlanIt\Http\Controllers;

use Illuminate\Http\Request;
use PlanIt\Event;
use PlanIt\User;
use PlanIt\Notification;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
      //$eventList = Event::paginate(20)->orderBy('start_time', 'desc');

      $eventList = DB::table('events')->orderBy('start_date', 'desc')->paginate(20);

      return view('events.index', ['events' => $eventList]);
    }

    public function view($id)
    {
      $event = Event::findOrFail($id);
      $eventAttendees = DB::table('eventattendees')
                              ->select('users.id as user_id', 'users.name as user_name')
                              ->join('users', 'users.id', '=', 'eventattendees.user_id')
                              ->where('eventattendees.event_id', '=', $id)
                              ->get();

      return view('events.details', ['event' => $event], ['eventattendees' => $eventAttendees]);
    }

    public function notification(Event $event)
    {
      return response()->json($event->notifications()->with('user')->latest()->get());
    }

    public function create()
    {
      return view('events.create');
    }

    public function store(Request $request)
    {
      $validatedData = $request->validate([
          'name' => 'required|max:255',
          'description' => 'required|max:1000',
          'location' => 'required',
          'type' => 'required',
          'start_date' => 'required|date|after_or_equal:today',
          'end_date' => 'required|date|after_or_equal:start_date',
          'start_time' => 'required|date_format:H:i',
          'end_time' => 'required|date_format:H:i|after_or_equal:end_time',
      ]);

      $event = new Event();
      $event->user_id = $request->user_id;
      $event->name = $request->name;
      $event->type = $request->type;
      $event->description = $request->description;
      $event->location = $request->location;
      $event->start_date = $request->start_date;
      $event->end_date = $request->end_date;
      $event->start_time = $request->start_time;
      $event->end_time = $request->end_time;

      $event->save();

      return $this->index();
    }

    public function update(Request $request)
    {
      $validatedData = $request->validate([
          'name' => 'required|max:255',
          'description' => 'required|max:1000',
          'location' => 'required',
          'type' => 'required',
          'start_date' => 'required|date|after_or_equal:today',
          'end_date' => 'required|date|after_or_equal:start_date',
          'start_time' => '',
          'end_time' => 'after_or_equal:end_time',
      ]);

      $event = Event::findOrFail($request['id']);

      $updatedEvent = $event->update([
        'name' => $validatedData->name,
        'user_id' => Auth::id(),
        'type' => $validatedData->type,
        'description' => $validatedData->description,
        'location' => $validatedData->location,
        'start_date' => $validatedData->start_date,
        'start_time' => $validatedData->start_time,
        'end_date' => $validatedData->end_date,
        'end_time' => $validatedData->end_time
      ]);

      $updatedEvent->save();

      $updatedEvent = Event::where('id', $updatedEvent->id)->with('user')->first();

      return $updatedEvent->toJson();
    }

    public function delete(Request $request){
      $event = Event::findOrFail($request['id']);

      try{
          Event::where('id', '=', $event->id)->delete();
      }
      catch (Exception $e)
      {
        return $e;
      }

      return $this->index();
    }

    public function join(Request $request){
      $event = Event::findOrFail($request['event_id']);
      $user = User::findOrFail($request['user_id']);

      $attendees = DB::table('eventattendees')->select('user_id')->where('event_id', '=', $event->id)->get();
      if(!$attendees->contains('user_id', $user->id))
      {
        try {
          DB::table('eventattendees')->insert([
            'event_id' => $event->id, 'user_id' => $user->id
          ]);
        }
        catch (Exception $e)
        {
          return $e;
        }
      }

      return $this->view($event->id);
    }

    public function leave(Request $request){
      $event = Event::findOrFail($request['event_id']);
      $user = User::findOrFail($request['user_id']);

      try{
        DB::table('eventattendees')->where([
          'event_id' => $event->id, 'user_id' => $user->id
        ])->delete();
      }
      catch (Exception $e)
      {
        return $e;
      }

      return $this->view($event->id);
    }
}
