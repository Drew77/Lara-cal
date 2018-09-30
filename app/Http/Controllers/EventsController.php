<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Event;
use Illuminate\Support\Facades\Auth;
use DateTime;

class EventsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Find users Events
        $user = Auth::user()->id;
        $all_events = Event::where('creator_id', "=", $user)->orderBy('date_on', 'asc')->get();
        
        // If user has no events, redirect
        if (count($all_events) == 0) {
            $request->session()->flash('message', 'You have no events'); 
            return redirect('/home');
        }
        
        // Split Events into past and upcoming
        $upcoming_events = array();
        $past_events = array();
        foreach( $all_events as $event) {
            if ($event->date_on > date("Y-m-d H:i:s")){
                $upcoming_events[] = $event;
            }
            else {
                $past_events[] = $event;
            }
        }
        $day = new DateTime('now');
        $today = new DateTime('now');
        
        $days = array('Mon', 'Tue', 'Wed', 'Thurs', 'Fri', 'Sat', 'Sun');
        
        // Find first day of month
        while (date('d', $day->getTimestamp()) != '01'){
            $day->modify("-24 hours");
        }
        
        // Find Month to display for calendar
        if ($request->input('month') != null and is_numeric($request->input('month'))){
            $offset = $request->input('month');
            $day->modify($offset . " months");
        }
        else {
            $offset = 0;
        }
        
        $month = date('F', $day->getTimestamp());
        $firstDayOfMonth = $day->getTimestamp();

        // Find first date displayed
         while (date('D', $day->getTimestamp()) != 'Mon'){
             $day->modify("-24 hours");
         }
        $first_displayed = $day;
        // Sets the offsets for month navigation
        $previous_month = $offset-1;
        $next_month = $offset+1;
        
        // find events in current 6 week period to be displayed
        
        $current_events = array();
        $end_date = clone $first_displayed;
        $end_date->modify("+ 41days");
        foreach ($all_events as $event){
            $event_date = strtotime($event->date_on);
            if ($event_date > $first_displayed->getTimestamp() and $event_date < $end_date->getTimestamp()  ){
                 $current_events[] = $event;
             }
        }
        
         
        $events = array('upcoming_events' => $upcoming_events, 'past_events' => $past_events);
        return View('events.index', compact('events','end_date', 'event_date', 'current_events', 'first_displayed', 'day', 'today', 'days', 'month', 'offset', 'previous_month', 'next_month'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return View('events.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $event = new Event();
        $event->title = $request->title;
        $event->description = $request->description;
        $event->date_on = $request->date_on;
        $event->creator_id = Auth::user()->id;
        $event->save();
        $request->session()->flash('message', 'You created this event'); 
        return View('events.show')->with('event', $event);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $event = Event::find($id);
        
        if (Auth::id() === $event["creator_id"]){
             return View('events.show')->with('event', $event);
        }
        else {
           return redirect('/home')->withErrors(['error' => 'You are not authorized to view that Event']);
        }
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $event = Event::find($id);
        if (Auth::id() === $event["creator_id"]){
             return View('events.edit')->with('event', $event);
        }
        else {
           return redirect('/home')->withErrors(['error' => 'You are not authorized to view that Event']);
        }        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $event = Event::find($id);
        if (Auth::id() === $event["creator_id"]){
            $event->title = $request->title;
            $event->description = $request->description;
            $event->date_on = $request->date_on;
            $event->save();
            $request->session()->flash('message', 'You successfully edited this event'); 
            return View('events.show')->with('event', $event);
        }
        else {
           return redirect('/home')->withErrors(['error' => 'You are not authorized to view that Event']);
        }        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $event = Event::find($id);
        $user = Auth::user()->id;
        if ($user === $event["creator_id"]){
            $event->delete();
            $request->session()->flash('message', "You deleted $event->title"); 
            return redirect('/events');
        }
        else {
           return redirect('/home')->withErrors(['error' => 'You are not authorized to delete that Event']);
        }  
    }
}
