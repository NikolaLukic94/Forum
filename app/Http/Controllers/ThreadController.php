<?php

namespace App\Http\Controllers;
 
use App\Filters\ThreadFilters;
use Auth;
use App\Channel;
use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index(Channel $channel, ThreadFilters $filters)
    {
       // $threads = $this->getThreads($chanel, $filters);

        if(request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index',[
          //  'threads' => $threads
            'threads'=> Thread::all()
        ]);
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store($channelId, Request $request, Spam $spam)
    {
        $this->validate($request, [
            'title' => 'required|spamfree',
            'body' => 'required|spamfree',
            'channel_id' => 'required|exists:channels,id'
        ]);


        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
     //       'slug' => request('title')    SLUG IS BEING SET AUTOMATICALLY BY A MODEL EVEN
        ]);

        return redirect('/threads'. $thread->id);
    }

    public function show($channelId, Thread $thread)
    {

        if(auth()->check()) {
            auth()->user()->read($thread);
        }

        $thread->increment('visits');

        return view('threads.show', compact('thread'));
    }

    public function edit(Thread $thread)
    {
        //
    }

    public function update(Request $request, Thread $thread)
    {
        //
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);
        $thread->replies()->delete();
        $thread->delete();
    }

    protected function getThreads(Channel $channel, ThreadFilters $filters)
    {
        $thread = Thread::latest()->filter($filters); //loading it with channel relationship since this is added as a global scope

        if($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->get();
    }
}
