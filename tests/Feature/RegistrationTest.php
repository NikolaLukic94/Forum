<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegistrationTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_a_confirmation_email_is_sent_upon_refistration()
    {
        Mail::fake();

        $this->post('/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar'
        ]);

        Mail::assertSent(PleaseConfirmYourEmail::class);
    }

    public function test_a_user_can_fully_confirm_their_email_address()
    {
        Mail::fake();

        $this->post('/register', [
            'name' => 'John',
            'email' => 'john@example.com',
            'password' => 'foobar',
            'password_confirmation' => 'foobar'
        ]);

        $user = User::whereName('John')->first();

        $this->assertFalse($user->confirmed); 
        $this->assertNotNull($user->confirmation_token);

        $this->get('/register/confirm?token=' . $user->confirmation_token);

        $this->assertTrue($user->confirmed);
        $this->assertNull($user->confirmation_token);

        $response->assertRedirect('/threads');
    }

    public function test_confirming_an_invalid_token()
    {
        $this->get(route('register.confirm', ['token' => 'invalid']))
             ->assertRedirect(route('threads'))
             ->assertSessionHas('flash', 'Unknown token');
    }
}
