@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Threads:</div>

                <div class="card-body">
                    @foreach ($threads as $thread)
                        <article>
                            <div class="level">
                                <h4 class="flex">
                                    <a href="{{$thread->path()}}">{{$thread->title}}</a>
                                </h4>
                                <a href="{{ $thread->path() }}">
                                    <p>{{ $thread->replies()->count() }} {{ str_plural('comment',$thread->replies()->count() ) }}</p>
                                </a>
                            </div>
                        </article>
                        <div class="body">{{$thread->body}}</div>
                        <hr>
                    @endforeach    
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
