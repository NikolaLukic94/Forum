@extends('layouts.app')

@section('content')
<div class="container"><!-- container -->
    <div class="row justify-content-center"><!-- row justify-content-center -->
        <div class="col-md-8"><!-- col-md-8 -->
            <div class="card"><!-- card -->
                <div class="card-header"><!-- card-header -->
                    <div class="level"><!-- level -->
                        <span class="flex">
                            <a href="/profiles/{{ $thread->creator->name }}">
                            {{$thread->creator->name}}
                            </a> posted:
                        </span>
                        <b>{{$thread->title}}</b>
                        <form action="{{$thread->path() }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-link">
                                Delete Thread
                            </button>
                        </form>                        
                    </div><!-- level -->
                    @can('update', $thread)
                        <form action="{{$thread->path() }}" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                            <button type="submit" class="btn btn-link">Delete Thread</button>
                        </form>
                    @endif
                </div><!-- card-header -->
                <div class="card-body"><!-- card-body -->
                    {{$thread->body}}
                </div><!-- card-body -->
            </div><!-- card -->   
            <br>
            <br>            
            @include('threads.reply')

            @if(auth()->check())        
                <form action="/threads/{{$thread->id}}/replies" method="POST" >
                    {{ csrf_field() }}
                        <textarea name="body" id="body" class="form-control" placeholder="Have something to say?" rows="5">
                        </textarea>
                    <button type="submit" class="btn btn-default">Post</button>
                </form>
            @else
                <p class="text-center"><a href="{{ route('login') }}">Please SignIn to participate in discussion.</a></p>
            @endif        
        </div><!-- col-md-8 end-->

        <div class="col-md-4"><!-- col-md-4 start -->
            <div class="card"><!-- card -->          
                    <div class="card-body">
                        <p>This thread was published {{ $thread->created_at->diffForHumans() }} by <a href="#">{{ $thread->creator->name }}</a>, and currently has {{ $thread->replies()->count() }} {{ str_plural('comment',$thread->replies()->count() ) }} comments.</p>
                        <p>
                            <subscribe-button></subscribe-button>   
                            <button class="btn btn-default">Subscribe</button>
                        </p>

                    </div>
            </div><!-- card -->  
        </div><!-- col-md-4 end -->

    </div><!-- row justify-content-center -->
</div><!-- container -->
@endsection
