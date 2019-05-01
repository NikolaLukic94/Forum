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
}
