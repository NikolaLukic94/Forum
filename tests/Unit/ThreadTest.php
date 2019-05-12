<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_a_thread_can_have_replies(){

        $thread = factory('App\Thread')->create();

        $response = $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
    }

    public function test_a_thread_can_make_a_string_path() 
    {
        $thread = create('App\Thread');

        $this->assertEquals(
            "/threads/{$thread->channel->slug}/{$thread->id}", $thread->path()
        );
    }

    public function test_a_thread_has_a_creator() {

        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\User', $thread->creator);
    }

    public function test_a_thread_has_a_reply() {

        $this->thread = factory('App\Thread')->create();

        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_belongs_to_a_channel() {

        $thread = factory('App\Thread')->create();

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

    public function test_a_user_can_subscribe_to_a_thread()
    {
        //given we have a user
        $thread = create('App\Thread');
        //when the users subscribes to the thread
        $thread->subscribe($userId = 1);
        //then we shoould be able to fetch all threads that the user has subscribed to
        $this->assertEquals(
        	1,
        	$thread->subscriptions()->where('user_id', auth()->id())->count()
        );
    }

    public function test_a_thread_can_be_unsubscribed_from() 
    {
        $thread = create('App\Thread');

        $thread->subscribe($userId = 1);

        $thread->unsubscribe($userId);

        $this->assertCount(0, $thread->subscriptions);
    }

    public function test_a_thread_records_each_visit()
    {
        Redis::del("threads.{$thread->id}.visits");

        $thread = make('App\Thread', ['id' => 1]);

        $thread->recordVisit();

        $this->assertEquals(1, $thread->visits());

        $thread->recordVisit();

        $this->assertEquals(2, $thread->visits());
    }

    public function it_knows_if_the_authenticated_user_is_subscribed_to_it() {

        $thread = create('App\Thread');

        $this->signIn();

        $thread->subscribe();

        $this->assertTrue($thread->isSubscribedTo);

    }
}
