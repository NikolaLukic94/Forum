@extends('layouts.app')

@section('content')
<div class="container"><!-- container -->
    <div class="row justify-content-center"><!-- row justify-content-center -->
        <div class="col-md-8"><!-- col-md-8 -->
            @foreach ($threads as $thread)
            <div class="card"><!-- card -->
                <div class="card-body"><!-- card body -->
                    <article>
                        <div class="level"><!-- level -->
                            <h4 class="flex">
                                <a href="{{$thread->path()}}">{{$thread->title}}</a>
                            </h4>
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
        </div><!-- col-md-8 -->
    </div><!-- row justify-content-center -->
</div><!-- container -->
@endsection
