@component('profiles.activities.activity')
	@slot('heading')
		{{$profileUser->name}} published a reply
	@endslot
	@slot('body')
		{{$activity->subject->body}}
	@endslot	
@endcomponent
