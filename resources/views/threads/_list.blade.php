@foreach ($threads as $thread)
            <div class="card"><!-- card -->
                <div class="card-body"><!-- card body -->
                    <article>
                        <div class="level"><!-- level -->
                            <h4 class="flex">
                                @if($thread->hasUpdatesFor(auth()->user()))
                                <b><a href="{{$thread->path()}}">{{$thread->title}}</a></b>
                                @else
                                <a href="{{$thread->path()}}">{{$thread->title}}</a>
                                @endif
                            </h4>
                            <h5>
                                Posted by: <a href="/thread/{{$thread->creator}}">{{$thread->creator->name}}</a>
                            </h5>
                            <a href="{{ $thread->path() }}">
                                <p>{{ $thread->replies()->count() }} {{ str_plural('comment', $thread->replies()->count() ) }}</p>
                            </a>

                        </div><!-- level -->
                    </article>
                    <div class="body">
                        {{$thread->body}}
                    </div>
                </div><!-- card body -->
                <div class="card-footer text-muted">
                    {{ $thread->visits }} Visits
                </div>
            </div><!-- card -->  
            <br>  
@endforeach    