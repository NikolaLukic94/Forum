@extends('layouts.app')

@section('content')
<div class="container">
	<div class="col-md-8 offset-2">
	<div class="page-header text-center">
		<h1>
			{{ $profileUser->name }}
			<small>
			Since {{ $profileUser->created_at->diffForHumans() }}
			</small>
		</h1>
	</div>	
	</div>
	<br>
	@foreach($activities as $date => $activity)
		<h3 class="page-header">{{$date}}</h3>
		@foreach($activity as $record)
			@if(view()->exists('profiles.activities.{$record->type}'))
				@include('profiles.activity.{$record->type}', ['activity' => $record])
			@endif
		@endforeach
	@endforeach
</div>	
@endsection