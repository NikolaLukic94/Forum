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

    public function test_a_reply_requires_a_body() 
    {
        $this->withExceptionHandling()->signIn();

        $thread->create('App\Thread');
        $reply = make('App\Reply', ['body' => null ]);

        $this->post($thread->path() . '/replies', $reply->toArray())
             ->assertSessionHasErrors('body');
    }

    public function test_replies_that_contain_spam_may_not_be_created() {
        
        $this->signIn();

        $thread = create('App\Thread');
        $reply = make('App\Reply', [
            'body' => 'Yahoo Customer Support'
        ]);

        $this->expectException(\Exception::class);

        $this->post($thread->path() . '/replies' . $reply->toArray())
             ->assertStatus(422);

    }
}
