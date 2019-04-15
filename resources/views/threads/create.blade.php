@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Create A Thread:</div>
                <form method="POST" action="threads/create">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="channel_id">Chose a channel:</label>
                        <select name="channel_id" id="channel_id" class="form-control">
                            <option value="">Choose one...</option>
                            @foreach($channels as $channel)
                            <option value="{{ $channel->id }}" {{old('channel_id') == $channel->id ? 'selected' : '' }}>{{$channel->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input type="text" name="title">  
                    <input type="text" name="body">
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit">Post</button>    
                    </div>
                </form>
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
@endsection