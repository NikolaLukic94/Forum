<div class="card">
    @foreach($thread->replies as $reply)
    <div class="card-header">
        <div class="level">
            <div class="flex">
                <a href="/profiles/{{ $reply->owner->name }}">
                    {{$reply->owner->name}} said
                    {{$reply->created_at->diffForHumans()}}
                </a>
            </div>
        <div>

        <form action="/replies/{{ $reply->id }}/favorites" method="POST">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-default" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                {{ $reply->favorites_count }}
                {{ str_plural('Favorite', $reply->favorites_count) }}
            </button>
        </form>
    </div>
</div>
    </div>
        
    <div class="card-body">
        {{$reply->body}}
    </div>
    @endforeach
</div>