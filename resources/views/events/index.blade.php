@extends('layouts.app')

@section('content')

<div class="row">
    <div class="col-md-12 col-md-offset-0">
        @include('partials.calendar')
    </div>
</div>

<div class="col-md-8 col-md-offset-2">
@if (count($events["upcoming_events"]) > 0)
  
  <div class="panel panel-default">
      <div class="panel-heading">Upcoming Events</div>

      <div class="panel-body">
          @foreach($events["upcoming_events"] as $event)
          
          <div class="">
              <a href="/events/{{ $event->id}}">{{$event->title}}</a>
          </div>
          @endforeach
      </div>                    
  </div>
@endif    

@if (count($events["past_events"]) > 0)
  <div class="panel panel-default">
      <div class="panel-heading">Past Events</div>

      <div class="panel-body">
          @foreach($events["past_events"] as $event)
          
          <div class="">
              <a href="/events/{{ $event->id}}">{{$event->title}}</a>
          </div>
          @endforeach
      </div>                    
  </div>
@endif 
</div>
    
@endsection
