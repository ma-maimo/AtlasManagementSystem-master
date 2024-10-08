<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\ReserveSettingUsers;
use App\Models\Calendars\Calendar;
use App\Models\USers\User;
use Auth;
use DB;

class CalendarsController extends Controller
{
    public function show()
    {
        $calendar = new CalendarView(time());
        return view('authenticated.calendar.general.calendar', compact('calendar'));
    }

    public function reserve(Request $request)
    {
        DB::beginTransaction();
        try {
            $getDate = $request->getDate;
            $getPart = $request->getPart;

            // 入力データの配列の長さを一致させる
            $countDate = count($getDate);
            $countPart = count($getPart);

            // 長さが違う場合、短い方に空の値を追加する
            if ($countDate > $countPart) {
                $getPart = array_pad($getPart, $countDate, '');
            } elseif ($countDate < $countPart) {
                $getDate = array_pad($getDate, $countPart, '');
            }

            // デバッグ: 配列の長さを確認
            // dd(['getDate' => $getDate, 'getPart' => $getPart]);

            // 日付とパートを組み合わせる
            $reserveDays = array_filter(array_combine($getDate, $getPart));

            // デバッグ: 組み合わせた結果を表示
            // dd($reserveDays);

            foreach ($reserveDays as $key => $value) {
                $reserve_setting = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();


                // $reserve_settings->decrement('limit_users');
                // $reserve_settings->users()->attach(Auth::id());
                if ($reserve_setting) {
                    // 制限人数を減少させる
                    $reserve_setting->decrement('limit_users');

                    // ユーザーを予約に関連付ける
                    $reserve_setting->users()->attach(Auth::id());
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    // 予約削除処理
    public function cancel(Request $request)
    {
        $reserve_setting_id = $request->input('reserve_setting_id');
        $user_id = Auth::id();

        // ログインユーザーの対象の予約だけ削除
        $reservation = ReserveSettingUsers::where('reserve_setting_id', $reserve_setting_id)
            ->where('user_id', $user_id)
            ->first();

        if ($reservation) {
            $reservation->delete();  // 該当する予約を削除
        }

        // 残りの予約枠数を増やす
        $reserveSetting = ReserveSettings::findOrFail($reserve_setting_id);
        $reserveSetting->limit_users += 1;
        $reserveSetting->save();

        return redirect()->route('calendar.general.show', ['user_id' => $user_id]);


        // dd($reserve_setting_id);
        // ReserveSettingUsers::where('reserve_setting_id', $reserve_setting_id)->delete();
        // return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }
}