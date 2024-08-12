@extends('layouts.sidebar')
@section('content')
<div class="w-100 d-flex" style="align-items:center; justify-content:center;">
      <div class="w-100 pt-4 pb-3">
            <div class="reserve_setting_calendar">
                  <p class="text-center">{{ $calendar->getTitle() }}</p>
                  {!! $calendar->render() !!}
            </div>
            <div class="adjust-table-btn m-auto text-right">
                  <input type="submit" class="btn btn-primary admin_reserve_btn" value="登録" form="reserveSetting" onclick="return confirm('登録してよろしいですか？')">
            </div>
      </div>
</div>
@endsection
