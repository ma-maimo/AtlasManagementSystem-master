<?php

namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarWeekDay
{
  protected $carbon;

  function __construct($date)
  {
    $this->carbon = new Carbon($date);
  }

  function getClassName()
  {
    return "day-" . strtolower($this->carbon->format("D"));
  }

  function render()
  {
    return '<p class="day">' . $this->carbon->format("j") . '日</p>';
  }

  function everyDay()
  {
    return $this->carbon->format("Y-m-d");
  }

  // function dayPartCounts($ymd)
  // {
  //   $html = [];
  //   $one_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '1')->first();
  //   $two_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '2')->first();
  //   $three_part = ReserveSettings::with('users')->where('setting_reserve', $ymd)->where('setting_part', '3')->first();

  //   $html[] = '<div class="text-left">';
  //   if ($one_part) {
  //     $html[] = '<p class="day_part m-0 pt-1">1部</p>';
  //   }
  //   if ($two_part) {
  //     $html[] = '<p class="day_part m-0 pt-1">2部</p>';
  //   }
  //   if ($three_part) {
  //     $html[] = '<p class="day_part m-0 pt-1">3部</p>';
  //   }
  //   $html[] = '</div>';

  //   return implode("", $html);
  // }

  function dayPartCounts($ymd)
  {
    $html = [];
    $parts = ['1', '2', '3'];

    $html[] = '<div class="text-left">';

    foreach ($parts as $part) {
      // 各予約枠に対する予約人数を取得
      $reserveSetting = ReserveSettings::where('setting_reserve', $ymd)
        ->where('setting_part', $part)
        ->withCount('users')
        ->first();

      $count = $reserveSetting ? $reserveSetting->users_count : 0;

      $html[] = '<p class="day_part m-0 pt-1">' . $part . '部　' . $count . '</p>';
    }

    $html[] = '</div>';

    return implode("", $html);
  }


  // public function dayPartCounts($date)
  // {
  //   // 予約枠を取得
  //   $parts = $this->getDayParts(); // 予約枠の取得方法は実際のコードに合わせて変更

  //   // 予約があるかどうかに関わらず、すべての予約枠を表示
  //   $html = '<div class="day-parts">';
  //   foreach ($parts as $part) {
  //     // 各予約枠の詳細を表示
  // $count = $this->getReservationCountForPart($date, $part); // 各予約枠の予約人数を取得
  // $html .= '<div class="part">' . $part . ' - 予約人数: ' . $count . '</div>';
  //   }
  //   $html .= '</div>';

  //   return $html;
  // }

  // private function getDayParts()
  // {
  //   // 予約枠の配列を返す（例）
  //   return ['9:00 - 10:00', '10:00 - 11:00', '11:00 - 12:00'];
  // }

  // private function getReservationCountForPart($ymd, $part)
  // {
  //   // 指定された日付と予約枠の予約人数を取得するクエリを実行
  //   return ReserveSettings::where('setting_reserve', $ymd)
  //     ->where('setting_part', $part)
  //     ->count();
  // }



  function onePartFrame($day)
  {
    $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first();
    if ($one_part_frame) {
      $one_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '1')->first()->limit_users;
    } else {
      $one_part_frame = "20";
    }
    return $one_part_frame;
  }
  function twoPartFrame($day)
  {
    $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first();
    if ($two_part_frame) {
      $two_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '2')->first()->limit_users;
    } else {
      $two_part_frame = "20";
    }
    return $two_part_frame;
  }
  function threePartFrame($day)
  {
    $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first();
    if ($three_part_frame) {
      $three_part_frame = ReserveSettings::where('setting_reserve', $day)->where('setting_part', '3')->first()->limit_users;
    } else {
      $three_part_frame = "20";
    }
    return $three_part_frame;
  }

  //
  function dayNumberAdjustment()
  {
    $html = [];
    $html[] = '<div class="adjust-area">';
    $html[] = '<p class="d-flex m-0 p-0">1部<input class="w-25" style="height:20px;" name="1" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">2部<input class="w-25" style="height:20px;" name="2" type="text" form="reserveSetting"></p>';
    $html[] = '<p class="d-flex m-0 p-0">3部<input class="w-25" style="height:20px;" name="3" type="text" form="reserveSetting"></p>';
    $html[] = '</div>';
    return implode('', $html);
  }
}