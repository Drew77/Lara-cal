@extends('layouts.app')

@section('content')

    
<div class="col-md-8 col-md-offset-2">   
  <div class="panel panel-default">
    <div class="panel-heading">Create An Event</div>
      <div class="panel-body">
        {!! Form::open(['method'=>'POST', 'action' => 'EventsController@store', 'class'=>'form-horizontal']) !!}
          <div class="form-group">
            {!! Form::label('title', 'Event Title', ['class' => 'col-md-4 control-label']); !!}
            <div class="col-md-6">
              <input type="text" name="title" class="form-control" id="title" aria-describedby="title">
            </div>
          </div>
          
          <div class="form-group">
            {!! Form::label('description', 'Event Description', ['class' => 'col-md-4 control-label']); !!}
            <div class="col-md-6">
              <textarea class="form-control" name="description" id="title" aria-describedby="description"></textarea>
            </div>
          </div>
          <div class="form-group">
            {!! Form::label('date_on', 'Event Date', ['class' => 'col-md-4 control-label']); !!}
            <div class="col-md-6">
              <input type="date" name="date_on" max="3000-12-31" min="{{ date("Y-m-d") }}" class="form-control" value="{{ date("Y-m-d") }}">
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Submit</button>
         {!! Form::close() !!}
       </div>
  </div>
</div>     
    
 
    
@endsection
