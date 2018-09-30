<style>
    
    .day {
        width: 14.2%;
        padding-right: 10px;
        padding-bottom: 10px;
    }    
    .calendar__day-of-the-week {
        width: 14.2%;
        text-align: center;
        padding-right: 10px;
    }
    .calendar__days-of-the-week {
        display: flex;
        justify-content: space-between;
    }
    .day__inner {
        padding: 10px;
        height: 150px;
        border: 1px solid black;
        background: rgba(0,0,0,0.2);
    }
    
    .active-month {
        background: rgba(0,0,0,0);
    }

    .calendar__week {
        display: flex;
    }
    .calendar {
        margin-top: 20px;
        padding-left: 15px;
        padding-right: 15px;
        flex-direction: column;
        display: flex;
    }
    .calendar__day {
        margin-top: 0;
    }
    .d-inline {
        display: inline-block;
        vertical-align: middle;
    }
    .calendar__month {
        width: 180px;
        padding: 5px 20px;
        margin: 0;
        line-height: 33px;
    }
    .today {
        background: pink;
    }

    
</style>

<div>
    <div class="text-center">
        <a href="/events?month={{$previous_month}}" class="btn btn-default d-inline">
            <span class="glyphicon glyphicon glyphicon-chevron-left"></span>
        </a>
        <h2 class="d-inline calendar__month">{{ $month }}</h2>
        <a href="/events?month={{$next_month}}" class="btn btn-default d-inline">
            <span class="glyphicon glyphicon-chevron-right"></span>
        </a>
    </div>
    <div class="calendar">
        <div class="calendar__days-of-the-week">
            @for ($i = 0; $i < 7; $i++)
                <div class="calendar__day-of-the-week">
                    <h3>{{ $days[$i]}}</h3>
                </div>
            @endfor
        </div>
        @for ($week = 0; $week < 6; $week++)
            <div class="calendar__week">
                @for ($day_number = 0; $day_number < 7; $day_number++)
                    @php
                        $current_month = date('F', $day->getTimestamp()) == $month ? " active-month" : "";
                        $current_day = $day->format('Y-m-d') == $today->format('Y-m-d') ? " today" : "";
                    @endphp
                    <div class="day">
                        <div class="day__inner{{$current_month . $current_day}}">
                            <h2 class="calendar__day">{{ date('d', $day->getTimestamp()) }}</h2>
                
                            @php 
                                
                                if (count($current_events) > 0) {
                                    while(true){
                                        if (date("Y-m-d", strtotime($current_events[0]->date_on)) == date("Y-m-d", $day->getTimestamp())){
                                            echo '<div><a href="/events/' . $current_events[0]->id . '">' . $current_events[0]->title . '</a></div>';
                                            array_shift($current_events);
                                            if (count($current_events) == 0){
                                                break;
                                            }
                                        }
                                        else {
                                            break;
                                        }
                                    }
                                }
                            @endphp
                        </div>
                    </div>
                    @php
                        $day->modify("+24 hours");
                    @endphp
                @endfor   
            </div>
        @endfor
    </div>
</div>