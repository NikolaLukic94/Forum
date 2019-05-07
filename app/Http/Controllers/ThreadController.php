<?php

namespace App\Http\Controllers;
 
use Auth;
use App\Channel;
use App\Thread;
use Illuminate\Http\Request;

class ThreadController extends Controller
{
    public function index(Channel $channel)
    {
        if ($channel->exists) {

            $threads = $channel->threads()->latest();
        } else {
            $threads = Thread::latest();
        }
        //if requested ('by'), we should filter by the given name
        if ($username = request('by')) {
            
            $user = \App\User::where('name', $username)->firstOrFail();
            $threads->where('user_id', $user->id);
        }

        $threads = $threads->get();

        if(request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index',[
            'threads' => $threads
        ]);
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store($channelId, Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'body' => 'required',
            'channel_id' => 'required|exists:channels,id'
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        return redirect('/threads'. $thread->id);
    }

    public function show($channelId, Thread $thread)
    {
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
        $thread = Thread::latest()->filter($filters);

        if($channel->exists) {
            $threads->where('channel_id', $channel->id);
        }

        return $threads->get();
    }
}
