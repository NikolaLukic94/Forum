<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{

    use RecordsActivity;

	protected $guarded = [];

    public $with = ['creator','channel'];

    protected static function boot() {
        parent::boot();

        static::addGlobalScope('replyCount', function($builder) {
            $builder->withCount('replies');
        });

        static::deleting(function ($thread) {
            $thread->replies->each->delete();
        });
    }


    public function path() {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies() {
    	return $this->hasMany(Reply::class)
                 /*   ->withCount('favorites') //reducing the number or SQL queries if done this way instead of calling a relationship in view
                    ->with('owner')*/;
    }

    public function creator() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function addReply($reply) {

    	$reply = $this->replies()->create($reply);
    
        $this->subscriptions->filter(function ($sub) use ($reply) {

            return $sub->user_id != $reply->user_id;
        })
        ->each(function ($sub) use ($reply) {
            $sub->user->notify(new ThreadWasUpdated($this, $reply));
        });

        return $reply;
    }

    public function notifySubscribers($reply) {

        $this->subscriptions
             ->where('user_id', '!=', $reply->user_id)
             ->each
             ->notify($reply);
    }

    public function channel() {
        return $this->belongsTo(Channel::class);
    }
/*
    publicstatic::deleting(function($thread){
        $thread->replies()->delete();
    });
    */

    public function subscribe($userId = null) {

        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id() //if id provded, use it, otherwise use auth->id
        ]);

        return $this;
    }

    public function subscriptions() {

        return $this->hasMany(ThreadSubscription::class);
    }


    public function unsubscribe() {
        $this->subscriptions()
             ->where('user_id', $userId ?: auth()->id())
             ->delete();
    }

    public function recordVisits() {

        Redis::incr($this->visitCacheKey());

        return $this;
    }

    public function visits() {

        return Redis::get($this->visitCacheKey()) ?? 0;
    }

    public function visitCacheKey() {

        return "threads.{$this->id}.visits";
    }

    public function resetVisits() {

        Redis::del($this->visitCacheKey());

        return $this;
    } 

    public function getIsSubscribedToAttribute() {

        return $this->subscriptions()
                    ->where('user_id', auth()->id())
                    ->exists();

    }

    public function hasUpdatesFor($user) {

        $key = $user->visitedThreadCacheKey($this);

        return $this->updated_at > cache($key);
    }

}
