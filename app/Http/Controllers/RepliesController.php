<?php

namespace App\Http\Controllers;
use App\Thread;
use Illuminate\Http\Request;
use App\Http\Request\CreatePostForm;

class RepliesController extends Controller
{
	public function __construct() {
		$this->middleware('auth');
	}

	public function store($channelId,Thread $thread, CreatePostForm $form) {
			//$this->authorize('create', new Reply);
		//return $form->persist($thread);
		$reply = $thread->addReply([
			'body' => request('body'),
			'user_id' => auth()->id()
		])->load('owner');
//add namespace to events, listeners
	}

	public function update(Reply $reply, Spam $spam) {

		$this->authorize('update', $reply);

		$this->validate(request(), ['body' => 'required|spamfree']);

		$reply->update(request('body'));
	}
}
