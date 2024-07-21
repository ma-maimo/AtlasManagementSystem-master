<?php

namespace App\Calendars\Admin;

use Carbon\Carbon;
use App\Models\Users\User;
use App\Models\calendars\ReserveSettings;

class CalendarView //スクール予約確認画面
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
    $html[] = '<table class="table m-auto border">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border">土</th>';
    $html[] = '<th class="border">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';

    $weeks = $this->getWeeks();
    $reservations = ReserveSettings::with('users')->get(); // 予約データを取得

    foreach ($weeks as $week) {
      $html[] = '<tr class="' . $week->getClassName() . '">';
      $days = $week->getDays();
      foreach ($days as $day) {
        $startDay = $this->carbon->format("Y-m-01");
        $toDay = $this->carbon->format("Y-m-d");

        // 日付が過去の日かどうかを判断し、過去の場合は past-day クラスが適用された <td> 要素が生成
        if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
          $html[] = '<td class="past-day border">';
          // そうでない場合は、日付に対応したクラス名を取得し、それを <td> 要素のクラス属性に追加
        } else {
          $html[] = '<td class="border ' . $day->getClassName() . '">';
        }
        // 日付の表示やその他の処理（render()メソッドやdayPartCounts()メソッド）が行われた後、</td>タグで要素を閉じる
        $html[] = $day->render();
        $html[] = $day->dayPartCounts($day->everyDay());
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';

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