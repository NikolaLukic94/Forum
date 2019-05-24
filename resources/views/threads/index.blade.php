@extends('layouts.app')

@section('content')
<div class="container"><!-- container -->
    <div class="row justify-content-center"><!-- row justify-content-center -->
        <div class="col-md-8"><!-- col-md-8 -->
            @include('threads._list')
        </div><!-- col-md-8 -->
    </div><!-- row justify-content-center -->
</div><!-- container -->
@endsection
