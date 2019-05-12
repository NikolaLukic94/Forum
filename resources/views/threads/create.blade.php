@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">                  
                <div class="card-header text-center">Create A Thread:</div>
                <form method="POST" action="/threads/create">
                    {{ csrf_field() }}
                    <div class="col">
                    <div class="form-group">
                        <label for="channel_id">Chose a channel:</label>
                        <select name="channel_id" id="channel_id" class="form-control">
                            <option value="">Choose one...</option>
                            @foreach($channels as $channel)
                            <option value="{{ $channel->id }}" {{old('channel_id') == $channel->id ? 'selected' : '' }}>{{$channel->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="title">Chose a Title:</label>
                        <input type="text" name="title">
                    </div>
                    <div class="form-group">
                        <label for="body">Text:</label>  
                        <input type="text" name="body">
                    </div>
                    <div class="form-group">
                    

                    {!! htmlFormSnippet() !!}
                    <input type="submit">

                @if(count($errors))
                    <ul class="alert alert-danger">
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                @endif    
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection