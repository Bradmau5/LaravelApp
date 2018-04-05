<?php

namespace PlanIt\Http\Controllers;

use Illuminate\Http\Request;
use PlanIt\User;

class UserController extends Controller
{
    public function getProfile($id)
    {
      $userId = User::findOrFail($id);

      return view('user.profile', ['user' => $userId]);
    }

    public function updateProfile(Request $request)
    {
      $user = User::findOrFail($request['id']);

      $user->name = $request['name'];
      $user->email = $request['email'];
      $user->location = $request['location'];
      $user->age_range = $request['age_range'];

      $user->save();

      return $this->getProfile($user->id);
    }
}
