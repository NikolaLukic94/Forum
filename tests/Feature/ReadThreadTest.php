<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ThreadTest extends TestCase
{
    use WithoutMiddleware;//disables csrf protection fortesting purpose

    public function test_a_user_can_browse_threads()
    {
        $this->thread = factory('App\Thread')->create();

        $response = $this->get('/threads')
        				 ->assertSee($this->thread->title);
    }
    
    public function test_a_user_can_view_single_thread()
    {
        $this->thread = factory('App\Thread')->create();

        $response = $this->get('/threads'.$this->thread->id)
        				 ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_associated_with_a_thread() 
    {
    	$this->thread = factory('App\Thread')->create();

    	$reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $response = $this->get('/threads'.$this->thread->id)
        				 ->assertSee($reply->body);
    }



    public function test_a_thread_can_make_a_string_path() {

        $thread = make('App\Thread');

        $this->assertEquals('/threads' . $thread->channel->slug . '/' . $thread->id, $thread->path());
    }

    public function test_a_thread_requires_a_title() {

        $this->withExceptionHandling()->signIn();

        $this->post('/threads', $thread)
            ->assertSessionHas('title');
    }

    public function test_a_user_can_filter_threads_buy_any_username() {
        
        $this->signIn(create('App\User', ['name' => 'JohnDoe']));

        $threadByJohn = create('App\Thread', ['user_id' => auth()->id()]);
        $threadNotByJohn = create('App\Thread');

        $this->get('threads?by=JohnDoe')
                ->assertSee($threadByJohn->title)
                ->assertDontSee($threadNotByJohn->title);
    }

    public function test_a_user_can_filter_threads_by_popularity()
    {
        $threadWithTwoReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithTwoReplies->id], 2);

        $threadWithThreeReplies = create('App\Thread');
        create('App\Reply', ['thread_id' => $threadWithThreeReplies->id], 3);

        $threadWithNoReplies = create('App\Thread');

        $response = $this->getJson('threads?poularity=1')->json();

        $this->assertEquals([3,2,0], array_colum($response, 'replies_count'));
    }

    public function test_a_users_can_filter_thread_by_those_that_are_unanswered()
    {
        $thread = create('App\Thread');
        create('App\Reply', ['thread_id' => $thread->id ]);

        $response = $this->getJson('threads?unanswered=1')->json();

        $this->assertCount(1, $response);
    }

    public function test_a_thread_can_be_subscribed_to()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $this->subscribe();

        $this->assertEquals(
            1, 
            $thread->subscriptions()->where('auth_id', auth()->id()->count()
        );
    }

    public function test_a_thread_can_be_unsubscribed_from() {

        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertCount(
            0,
            $thread->subscriptions
        );

    }

}
