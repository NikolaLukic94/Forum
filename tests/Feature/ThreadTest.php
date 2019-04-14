<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class ThreadTest extends TestCase
{
    use WithoutMiddleware;//disables csrf protection fortesting purpose
/*
    public function setUp() 
    {
    	parent::setUp();

    	$this->thread = factory('App\Thread')->create();
    }
*/
    public function testAUserCanBrowseThreads()
    {

        $response = $this->get('/threads')
        				 ->assertSee($this->thread->title);
    }
    //check why not working
    public function AUserCanViewSingleThread()
    {

        $response = $this->get('/threads'.$this->thread->id)
        				 ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_associated_with_a_thread() 
    {
    	//we already have a thread bcs of setUp method
    	$reply = factory('App\Reply')->create(['thread_id' => $this->thread->id]);

        $response = $this->get('/threads'.$this->thread->id)
        				 ->assertSee($reply->body);
    }

    public function test_a_thread_can_have_replies(){
        $thread = factory('App\Thread')->create();
        $response = $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $thread->replies);
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

        $thread = create('App\Thread');

        $this->assertInstanceOf('App\Channel', $thread->channel);
    }

}
