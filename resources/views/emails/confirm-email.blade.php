@component('mail::message')
One Last Step

We just need you to confirm your email address to prove that you're human.

@component('mail::button', ['url' => '/register/confirm?token=' . $user->confirmation_token])
	Confirm Email
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
