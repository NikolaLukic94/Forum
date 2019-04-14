<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParticipateInForum extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->be($user = factory('App\User')->create();

        $thread = factory('App\Thread')->create();

        $reply = factory('App\Reply')->make();

        $this->post('/threads/'.$thread->id.'/replies',$reply->toArray());

        $this->get('/threads'.$thread->id);

    }
    
    public function test_unauthenticated_user_may_not_add_replies()
    {
        $this->exceptException('Illuminate\Auth\AuthenticationException');

        $this->post('/threads/1/replies', ());

    }

}
