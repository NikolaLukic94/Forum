@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header flex">
                    <div class="level">
                        <a href="/profiles/{{ $thread->creator->name }}">
                        {{$thread->creator->name}}
                        </a> posted:
                        <b>{{$thread->title}}</b>
                    </div>
                @can('update', $thread)
                    <form action="{{$thread->path() }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-link">Delete Thread</button>
                    </form>
                @endif

                </div>
                <div class="card-body">
                    {{$thread->body}}
                </div><br>
        
        @include('threads.reply')
        @if(auth()->check())
        
        <form method="POST" action="/threads/{{$thread->id}}/replies">
            {{ csrf_field() }}

                <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5">
                </textarea>

            <button type="submit" class="btn btn-default">Post</button>
        </form>
        @else
            <p class="text-center"><a href="{{ route('login') }}">Please SignIn to participate in discussion.</a></p>
        @endif        


        <div class="col-md-4">
            <div class="card">
                    <div class="card-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by <a href="#">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies()->count() }} {{ str_plural('comment',$thread->replies()->count() ) }} comments.
                    </div>
            </div>   
            </div>             

        </div>
    </div>
    <br>


  

</div>
@endsection
