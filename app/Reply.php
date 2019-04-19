<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
	protected $guarded = [];

    public function owner() {
    	return $this->belongsTo(User::class, 'user_id');
    }

    public function favorites() {
    	return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite() {
    	//since we want user to be able to favorite reply only once
    	$attributes = ['user_id'=> auth()->id()];
    	if (! $this->favorites()->where($attributes)->exists()) {
			return $this->favorites()->create($attributes);    		
    	}
    	
    }
}
