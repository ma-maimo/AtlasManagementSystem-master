@extends('layouts.sidebar')

@section('content')
<!-- スクール予約確認画面 -->
<div class="w-100 mt-3 d-flex" style="align-items:center; justify-content:center;">
      <div class="w-75 m-auto">
            <div class="w-100 reserve_setting_calendar">
                  <p class="text-center">{{ $calendar->getTitle() }}</p>
                  <p>{!! $calendar->render() !!}</p>
            </div>
      </div>
</div>
<!--
<div class="w-100 vh-100 d-flex" style="align-items:center; justify-content:center;">
      <div class="w-100 vh-100 border pt-4 pb-3">
            <div class="reserve_setting_calendar">
                  <p class="text-center">{{ $calendar->getTitle() }}</p>
                  {!! $calendar->render() !!}
            </div>
      </div>
</div> -->

@endsection
