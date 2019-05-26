<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
/*
    	try {
	    	User::where('confirmation_token', request('token'))
	    		  ->firstOrFail()
	    		  ->confirm();    		
	    	} catch (\Exception $e) {
    				return redirect('/threads')->with('flash', 'Unknown token.');

	    	}

    	return redirect('/threads')->with('flash', 'Your account is now confirmed! You may post to the forum.');*/


    	$user = User::where('onfirmation_token', request('token'))->first();

    	if (! $user) {
    		return redirect(route('threads'))->with('flash', 'Unknown token');
    	}

    	$user->confirm();

    	return redirect(route('threads'))
    			->with('flash', 'Your account is now confirmed! You may post to the forum.');
    }
}
