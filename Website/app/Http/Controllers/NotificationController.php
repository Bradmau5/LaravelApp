<?php

namespace PlanIt\Http\Controllers;

use Illuminate\Http\Request;
use PlanIt\Notification;
use PlanIt\User;
use PlanIt\Event;

class NotificationController extends Controller
{
    public function index(User $user)
    {
      return response()->json($user->notifications()->latest()->get());
    }

    public function eventUpdated(Event $event, Request $request)
    {
        $notificaiton = $event->notification()->create([
            'notificationtemplate_id' => 0,
            'user_id' => Auth::id(),
            'event_id' => $event->id,
            'body' => $request->body
        ]);

        $comment = Comment::where('id', $comment->id)->with('user')->first();

        return $notification->toJson();
    }
}
