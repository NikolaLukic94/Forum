<div class="card">
    @foreach($thread->replies as $reply)
    <div class="card-header">
        {{$reply->owner->name}} said
        {{$reply->created_at->diffForHumans()}}</div>
        
    <div class="card-body">
        {{$reply->body}}
    </div>
    @endforeach
</div>