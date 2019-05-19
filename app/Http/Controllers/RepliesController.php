<?php

namespace App\Http\Controllers;
use App\Thread;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

	public function store(Reply $reply) {

		$this->validate(request(), ['body' => 'required|spamfree']);

		$thread->addReply(request([
			'body' => request('body'),
			'user_id' => auth()->id()
		]));

	return back();

	}

	public function update(Reply $reply, Spam $spam) {

		$this->authorize('update', $reply);

		$this->validate(request(), ['body' => 'required|spamfree']);
		$spam->detect(request('body'));

		$reply->update(request('body'));
	}
}
