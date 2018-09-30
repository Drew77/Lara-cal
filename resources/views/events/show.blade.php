@extends('layouts.app')

@section('content')

<div class="col-md-4 col-md-offset-4">
  <div class="panel panel-default">
      <div class="panel-heading">{{ $event->title }}</div>
      <div class="panel-body">
        <h6 class="card-subtitle mb-2 text-muted">{{ date("d-m-Y" , strtotime($event->date_on))}}</h6>
        <p class="">{{ $event->description }}</p>
        <a href="/events/{{$event->id}}/edit" class="card-link btn btn-primary">Edit This Event</a>
        {!! Form::open(['method'=>'DELETE', 'action' => ['EventsController@destroy', $event->id ]]) !!}
          <button type="submit" class="btn btn-danger card-link">Delete Event</button>
        {!! Form::close() !!}      
      </div>

  </div>
</div>
@endsection
