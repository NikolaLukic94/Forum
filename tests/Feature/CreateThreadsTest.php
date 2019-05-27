<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{
    /** @test **/    
    public function a_guest_may_not_create_threads()
    {
        $this->withExceptionHandling()
             ->post('threads')
             ->assertRedirect('/login');
    }

    /** @test **/
    public function a_guests_cannot_see_the_thread_page() 
    {
        $this->withExceptionHandling()
             ->get('/threads/create')
             ->assertRedirect('/login');
    }

    /** @test **/
    public function unaouthorized_users_may_not_delete_threads() 
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread')->states('unconfirmed')->create();

        $response = $this->delete($thread->path())->assertRedirect('/login');

        $this->signIn();

        $this->delete($thread->path()->assertStatus(403));
    }
    /** @test **/
    
    public function a_authenticated_users_must_first_confirm_their_email_address()
    {
        $this->withExceptionHandling();

        $thread = create('App\Thread');

        $this->publishThread()
            ->assertRedirect('/threads')
            ->assertSessionHas('flash');
    }

    /** @test **/
    public function a_thread_can_be_deleted() {

        $this->signIn();

        $thread = create('App\Thread', ['user_id' => auth()->id() ]);
        $reply = create('App\Reply', ['thread_id' => $thread->id ]);

        $response = $this->json('DELTE', $thread->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissin('threads', ['id' => $thread->id]);
        $this->assertDatabaseMissin('replies', ['id' => $reply->id]);
    }

    /** @test **/
    public function an_authenticated_user_can_create_new_forum_threads() 
    {
        $this->actingAs(factory('App\User')->create());

        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }

    /** @test **/
    public function a_thread_requires_a_title() 
    {
        $this->publishThread(['title' => null ])
             ->assertSessionHasErrors('title');
    }

    /** @test **/
    public function a_thread_requires_a_body() 
    {
        $this->publishThread(['body' => null ])
             ->assertSessionHasErrors('body');
    }

    /** @test **/
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', ['title' => 'Foo Title' ]);

        $this->assertEquals($thread->slug, 'foo-title');

        $thread = $this->postJson(route('threads'), $thread->toArray())->json();

        $this->assertEquals("foo-title-{$thread['id']}" . $thread['slug']);
    }

    /** @test **/
    public function a_thread_requires_a_valida_channel()
    {
        factory('App\Channel', 2)->create();

        $this->publishThread(['channel_id' => null ])
             ->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999 ])
             ->assertSessionHasErrors('channel_id');

    }

    /** @test **/
    public function publishThread($overrides = [])
    {
        $this->withExceptionHandling->actingAs(create('App\User'));

        $thread = make('App\Thread', $overrides);

        return $this->post('/threads', $thread->toArray());
    }

    /** @test **/
    public function a_thread_with_a_title_that_ends_in_a_num_should_generate_the_proper_slug()
    {
        $this->signIn();

        $thread = create('App\Thread', ['title' => 'Foo Title 24' ]);    
        
        $this->post(route('threads'), $thread->toArray());

        $this->assertTrue(Thread::whereSlug('some-title-24')->exists());    
    } 
}
