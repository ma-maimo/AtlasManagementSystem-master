@extends('layouts.sidebar')

@section('content')
<!-- <div class="w-75 m-auto">
      <div class="w-100">
            <p>{{ $calendar->getTitle() }}</p>
            <p>{!! $calendar->render() !!}</p>
      </div>
</div> -->


<style>
.past-day {
      background-color: #0000FF;
}
</style>

<div class="w-75 m-auto">
      <div class="w-100">
            <p>{{ $calendar->getTitle() }}</p>
            <table class="calendar-table">
                  <thead>
                        <tr>
                              @foreach($calendar->getWeekdays() as $weekday)
                              <th>{{ $weekday }}</th>
                              @endforeach
                        </tr>
                  </thead>
                  <tbody>
                        @foreach($calendar->getWeeks() as $week)
                        <tr>
                              @foreach($week->getDays() as $day)
                              @php
                              $startDay = $calendar->getStartDay();
                              $toDay = $calendar->getToDay();
                              $classes = ['border'];
                              if ($day->everyDay()

                              < $toDay) { $classes[]='past-day' ; } @endphp <td class="{{ implode(' ', $classes) }}">
                                    {!! $day->render() !!}
                                    {!! $day->dayPartCounts($day->everyDay()) !!}
                                    </td>
                                    @endforeach
                        </tr>
                        @endforeach
                  </tbody>
            </table>
      </div>
</div>

@endsection