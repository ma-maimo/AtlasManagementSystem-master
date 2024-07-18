<?php

namespace App\Calendars\General;

class CalendarWeekBlankDay extends CalendarWeekDay
{ //空白でカレンダーのレイアウトを整える役割
  function getClassName()
  {
    return "day-blank";
  }

  /**
   * @return
   */

  function render()
  {
    return '';
  }

  function getDate()
  {
    return '';
  }
  function selectPart($ymd)
  {
    return '';
  }


  function cancelBtn()
  {
    return '';
  }

  function everyDay()
  {
    return '';
  }
}