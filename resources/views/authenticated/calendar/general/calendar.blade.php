@extends('layouts.sidebar')

@section('content')
<div class="w-100 pt-5" style="background:#ECF1F6;">
      <div class="w-90 m-auto pt-5 reserve_setting_calendar" style="border-radius:5px; background:#FFF;">

            <p class="text-center">{{ $calendar->getTitle() }}</p>
            <div class="w-85 m-auto">
                  <div class="">
                        {!! $calendar->render() !!}
                  </div>
            </div>

            <div class="text-right reserve_btn w-75 m-auto">
                  <input type="submit" class="btn btn-primary" value="予約する" form="reserveParts">
            </div>
      </div>
</div>
@endsection
