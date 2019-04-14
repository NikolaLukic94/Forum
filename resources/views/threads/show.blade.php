@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <a href="#">
                        {{$thread->creator->name}}
                    </a> posted:
                    <b>{{$thread->title}}</b>
                </div>
                <div class="card-body">
                    {{$thread->body}}
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-7">
            @include('threads.reply')
        </div>
    </div>   
    @if(auth()->check())
    <div class="row justify-content-center">
        <div class="col-md-7">
            <form method="POST" action="/threads/{{$thread->id}}/replies">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5">
                    </textarea>
                </div>
                <button type="submit" class="btn btn-default">Post</button>
            </form>
        </div>
    </div> 
    @else
        <p class="text-center"><a href="{{ route('login') }}">Please SignIn to participate in discussion.</a></p>
    @endif
</div>
@endsection
