<div class="card">
    @foreach($thread->replies as $reply)
    <div class="card-header">
    	<div class="level">
    		<div class="flex">
		        {{$reply->owner->name}} said
		        {{$reply->created_at->diffForHumans()}}
       	    </div>
    	<div>
        <form action="/replies/{{ $reply->id }}/favorites" method="POST">
		    {{ csrf_field() }}
            <button type="submit" class="btn btn-default">Favorite</button>
        </form>
    </div>
</div>
    </div>
        
    <div class="card-body">
        {{$reply->body}}
    </div>
    @endforeach
</div>