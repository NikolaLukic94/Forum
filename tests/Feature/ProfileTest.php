<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProfileTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_user_has_a_profile()
    {
        $user = create('App\User');
        
        $this->get('/profiles/{{ $user->name }}')
             ->assertSee($user->name);
    }

    public function test_display_all_threads_create_by_the_associated_user() {

        $user = create('App\User');

        $thread = create('App\Thread', ['user_id' => $user->id]);

        $this->get('/profiles/{$user->name}')
             ->assertSee($thread->title)
             ->assertSee($thread->body);

    }
}
