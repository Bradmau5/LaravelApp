<?php

namespace PlanIt\Http\Controllers;

use Illuminate\Http\Requests;
use Request;
use Redis;

class SocketController extends Controller {
	public function index()
	{
		return view('socket');
	}
	public function writemessage()
	{
		return view('writemessage');
	}
	public function sendmessage(){
		$redis = Redis::connection();
		$redis->publish('message', Request::input('message'));
		return view('writemessage');
	}

	public function saveNotification($sender, $receiver, $type, $message)
	{
		$redis = Redis::connection();
		$redis->set([['sender', $sender],['receiver', $receiver],['type', $type],['message', $message]]);
	}

	public function requestNotification($user)
	{
		$redis = Redis::connection();
		$messages = $redis->get('message')->where('receiver:'.$user);

		foreach($messages as $message)
		{
			$redis->publish('message', $message);
		}
	}
}
