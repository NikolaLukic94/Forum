<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use Favoritable, RecordsActivity;

	protected $guarded = [];

    protected $with = ['owner','favorites']; //call the relationship for every single query

    protected $appends = ['favoritesCount','isFavorited'];
/*
    protected static function boot()
    {
    	Reply::boot();

    	static::created(function($reply) {
    		$reply->thread->increment('replies_count');
    	});

    	static::deleted(function ($reply) {
    		$reply->thread->decrement('replies_count');
    	}); 
    }
*/
    public function owner() 
    {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function thread() 
    {
 		return $this->belongsTo(Thread::class);
    }

    public function wasJustPublished() 
    {
        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function path()
    {
        return $this->thread->path() . "#reply-{$this->id}";
    }

    public function mentionedUsers() 
    {
        preg_match_all('/\@([^\s\.]+)/', $this->body, $matches);

        return $matches[1]; //matches minus the @ character
    }

    public function setBodyAttribute($body) 
    {
        $this->attributes['body'] = preg_replace('/@([\w\-]+)/', '<a href="/profiles/$1">$0</a>', $body);
    }

    public function isBest()
    {
        return $this->thread->best_reply_id == $this->id;
    }
}
