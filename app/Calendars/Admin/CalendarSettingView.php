<?php

namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Calendars\ReserveSettings;

class CalendarSettingView //スクール枠登録画面
{
  private $carbon;

  function __construct($date)
  {
    $this->carbon = new Carbon($date);
  }

  public function getTitle()
  {
    return $this->carbon->format('Y年n月');
  }

  public function render()
  {
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table m-auto border adjust-table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border saturday">土</th>';
    $html[] = '<th class="border sunday">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();

    foreach ($weeks as $week) {
      $html[] = '<tr class="' . $week->getClassName() . '">';
      $days = $week->getDays();

      foreach ($days as $day) {
        $startDay = $this->carbon->format("Y-m-01");
        $toDay = $this->carbon->format("Y-m-d");


        $class = '';
        if ($day) { // nullチェック
          if ($day->isSaturday()) {
            $class = 'saturday border';
          } elseif ($day->isSunday()) {
            $class = 'sunday';
          }
          if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
            $class .= ' past-day';
          }
        }

        $html[] = '<td class="border' . $class . '">';
        $html[] = $day ? $day->render() : '';
        $html[] = '<div class="adjust-area">';

        // if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
        //   $html[] = '<td class="past-day border">';
        // } else {
        //   $html[] = '<td class="border ' . $day->getClassName() . '">';
        // }
        // $html[] = $day->render();
        // $html[] = '<div class="adjust-area">';

        if ($day->everyDay()) {
          if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
            $html[] = '<p class="d-flex m-0 p-0 reserve_day">1部<input class="" style="height:16px;" name="reserve_day[' . $day->everyDay() . '][1]" type="text" form="reserveSetting" value="' . $day->onePartFrame($day->everyDay()) . '" disabled></p>';
            $html[] = '<p class="d-flex m-0 p-0 reserve_day">2部<input class="" style="height:16px;" name="reserve_day[' . $day->everyDay() . '][2]" type="text" form="reserveSetting" value="' . $day->twoPartFrame($day->everyDay()) . '" disabled></p>';
            $html[] = '<p class="d-flex m-0 p-0 reserve_day">3部<input class="" style="height:16px;" name="reserve_day[' . $day->everyDay() . '][3]" type="text" form="reserveSetting" value="' . $day->threePartFrame($day->everyDay()) . '" disabled></p>';
          } else {
            $html[] = '<p class="d-flex m-0 p-0 reserve_day">1部<input class="" style="height:16px;" name="reserve_day[' . $day->everyDay() . '][1]" type="text" form="reserveSetting" value="' . $day->onePartFrame($day->everyDay()) . '"></p>';
            $html[] = '<p class="d-flex m-0 p-0 reserve_day">2部<input class="" style="height:16px;" name="reserve_day[' . $day->everyDay() . '][2]" type="text" form="reserveSetting" value="' . $day->twoPartFrame($day->everyDay()) . '"></p>';
            $html[] = '<p class="d-flex m-0 p-0 reserve_day">3部<input class="" style="height:16px;" name="reserve_day[' . $day->everyDay() . '][3]" type="text" form="reserveSetting" value="' . $day->threePartFrame($day->everyDay()) . '"></p>';
          }
        }
        $html[] = '</div>';
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="' . route('calendar.admin.update') . '" method="post" id="reserveSetting">' . csrf_field() . '</form>';
    return implode("", $html);
  }

  protected function getWeeks()
  {
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while ($tmpDay->lte($lastDay)) {
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}