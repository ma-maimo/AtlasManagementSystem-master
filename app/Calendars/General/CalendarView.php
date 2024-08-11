<?php

namespace App\Calendars\General;

use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\ReserveSettingUsers;

use Carbon\Carbon;
use Auth;

class CalendarView //スクール予約画面のカレンダー
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

  function render()
  {
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
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
    foreach ($weeks as $week) {
      $html[] = '<tr class="' . $week->getClassName() . '">';
      $days = $week->getDays();

      foreach ($days as $day) {
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
          // $html[] = '<td class="calendar-td">';
          $html[] = '<td class="past-day reserve-calendar-td border">'; //変更
        } else {
          $html[] = '<td class="border reserve-calendar-td ' . $day->getClassName() . '">';
        }

        $html[] = $day->render();

        if (in_array($day->everyDay(), $day->authReserveDay())) {
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if ($reservePart == 1) {
            $reservePart = "リモ1部";
          } else if ($reservePart == 2) {
            $reservePart = "リモ2部";
          } else if ($reservePart == 3) {
            $reservePart = "リモ3部";
          }

          if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
            // 過去日で予約がある
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">' . $reservePart . '</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
            // 未来日で予約がある
          } else {
            // キャンセルボタン
            $html[] = '<button type="submit" class="btn btn-danger cancel_btn p-0 modal-open"
            name="delete_date" style="font-size:12px"
            data-toggle="modal"
            data-target="#modal-example"
            day="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve  . '"
            reserve_part="' . $reservePart . '"
            reserve_setting_id="' . $day->authReserveDate($day->everyDay())->first()->id  . '"
            method="post" name="delete_date" style="font-size:12px"
            value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '">' . $reservePart . '</button>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }

          // モーダルの中身
          $html[] = '
            <div class="modal cancel-modal">
                <div class="modal__bg modal-close"></div>
                <div class="modal__content">
                    <p class="reserve_day">予約日：</p>
                    <p class="reserve_part">時間：</p>
                    <p class="reserve_cancel">上記の予約をキャンセルしてもよろしいですか？</p>

                    <form action="' . route('cancel', ['reserve_setting_id' => $day->authReserveDate($day->everyDay())->first()->id]) . '" method="post">
                    <input type="hidden" name="day" class="day" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '">
                    <input type="hidden" name="reserve_part" class="reserve_part" value="' . $reservePart . '">
                    <input type="hidden" name="reserve_setting_id" class="reserve_setting_id" value="' . $day->authReserveDate($day->everyDay())->first()->id . '">
                     ' . csrf_field() . '
                    <button type="submit" class="submit_button">キャンセル</button>
                    </form>
                    <button type="button" class="submit_button modal-close">閉じる</button>
                </div>
            </div>';
        }


        if (in_array($day->everyDay(), $day->authReserveDay())) {
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if ($reservePart == 1) {
            $reservePart = "リモ1部";
          } else if ($reservePart == 2) {
            $reservePart = "リモ2部";
          } else if ($reservePart == 3) {
            $reservePart = "リモ3部";
          }
          // 過去日で予約がない
        } else if ($startDay <= $day->everyDay() && $toDay >= $day->everyDay()) {
          $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">受付終了</p>';
          $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          // 未来日で予約ない
        } else {
          $html[] = $day->selectPart($day->everyDay());
        }

        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '<input type="hidden" name="getDate[]" value="" form="reserveParts">';
    $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';
    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">' . csrf_field() . '</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';

    return implode('', $html);
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