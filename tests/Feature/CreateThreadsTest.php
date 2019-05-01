<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_guest_may_not_create_threads()
    {
        $this->withExceptionHandling()
             ->post('threads')
             ->assertRedirect('/login');
    }

    public function test_a_guests_cannot_see_the_thread_page() 
    {
        $this->withExceptionHandling()
             ->get('/threads/create')
             ->assertRedirect('/login');
    }

    public function unaouthorized_users_may_not_delete_threads() 
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $response = $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();

        $this->delete($thread->path()->assertStatus(403));
    }

    public function test_a_thread_can_be_deleted() {

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id() ]);
        $reply = create('App\Reply', ['thread_id' => $thread->id ]);

        $response = $this->json('DELTE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissin('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissin('replies', ['id' => $reply->id]);
    }

    public function an_authenticated_user_can_create_new_forum_threads() 
    {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }

    public function test_a_thread_requires_a_title() 
    {
        $this->publishThread(['title' => null ])
             ->assertSessionHasErrors('title');
    }

    public function test_a_thread_requires_a_body() 
    {
        $this->publishThread(['body' => null ])
             ->assertSessionHasErrors('body');
    }

    public function test_a_thread_requires_a_valida_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null ])
             ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999 ])
             ->assertSessionHasErrors('channel_id');

    }

    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling->actingAs(create('App\User'));

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }

}
