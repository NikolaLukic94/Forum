<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    	protected $guarded = [];

    	public function owner() {
    		return $this->belongsTo(User::class, 'user_id');
    	}

    	protected function favorites() {
    		return $this->morphMany(Favorite::class, 'favorited');
    	}

    	public function favorite() {
    		if (! $this->favorites()->where(['user_id' => auth()->id()])->exists()) {
    			return $this->favorites()->create(['user_id' => auth()->id() ]);
    		}
    	}
}
