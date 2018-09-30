@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <div class="panel-body">
                    <a href="/events/create">Create a New Event</a>
                </div>
            </div>
            @if (count($events) > 0)
            <div class="panel panel-default">
                <div class="panel-heading">Upcoming Events</div>

                <div class="panel-body">
                    @foreach($events as $event)
                    
                    <div class="">
                        <a href="/events/{{ $event->id}}">{{$event->title}}</a>
                    </div>
                    @endforeach
                </div>                    
            </div>
            @endif
        </div>
    </div>

        
@endsection
