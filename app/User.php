<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Activity;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path', 'confirmation_token', 'confirmed'
    ];

    /* to always be treated as boolean */

    protected $casts = [
        'confirmed' => 'boolean'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function confirm() {
        $this->confirmed = true;
        $this->confirmation_token = null;

        $this->save();
    }

    public function getRouteKeyName() {
        return 'name';
    }

    public function threads() {
        return $this->hasMany(Thread::class)->latest(); //to order them from newest to oldest
    }

    public function activity() {
        return $this->hasMany(Activity::class);
    }

    public function visitedThreadCacheKey($thread) {
        return sprintf("users.%s.visits.%s", $this->id(), $thread->id);
    }

    public function read($thread) {

        cache()->forever(
            $this->visitedThreadCacheKey($thread),
            \Carbon\Carbon::now()
        );
    }

    public function lastReply() {

        return $this->hasOne(Reply::class)->latest(); //hasOne since we'll take only the latest reply

    }

    public function avatar()
    {
        return asset($this->avatar_path ?: 'images/avatars/default.png');
    }
}
