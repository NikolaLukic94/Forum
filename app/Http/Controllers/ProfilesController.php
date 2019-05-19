<?php

namespace App\Http\Controllers;

use App\User;
use App\Thread;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user) {

    	return view('profiles.show',[
    		'threads' => $user->threads()->paginate(30),
    		'profileUser' => $user,
    		'activities' => Activity::feed($user)
    		//'threads' => $user->threads()->paginate(10)
    	]);
    }


}
