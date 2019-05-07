<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FavoritesTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_auth_user_can_fav_any_reply()
    {
        $reply = create('App\Reply');

        $this->post('/replies/'. $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }

    public function test_an_auth_user_can_fav_any_reply_only_once()
    {
        $this->signIn();
        $reply = create('App\Reply');

        try {
            $this->post('/replies/'. $reply->id . '/favorites');
            $this->post('/replies/'. $reply->id . '/favorites');            
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record twice!');
        }

        $this->assertCount(1, $reply->favorites);
    }

    public function test_guests_can_not_fav_anything() 
    {
        $this->post('replies/1/favorites')->assertRedirect('/login');
    }
}
