@component('profiles.activities.activity')
	@slot('heading')
		{{$profileUser->name}} favorited a reply
	@endslot
	@slot('body')
		{{$activity->subject->favorited->body}}
	@endslot	
@endcomponent
