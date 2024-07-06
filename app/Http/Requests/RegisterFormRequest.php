<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function getValidatorInstance()
    {
        // プルダウンで選択された値(= 配列)を取得
        $old_year = $this->input('old_year');
        $old_month = $this->input('old_month');
        $old_day = $this->input('old_day');

        // 日付を作成
        $birth_day = $old_year . '-' . $old_month . '-' . $old_day;

        // rules()に渡す値を追加でセット
        $this->merge([
            'birth_day' => $birth_day,
        ]);


        return parent::getValidatorInstance();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //追加
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'under_name_kana' => 'required|string|regex:/\A[ァ-ヴー]+\z/u|max:30',
            'mail_address' => 'required|email|max:100|unique:users,mail_address,',
            'sex' => 'required',
            'old_year' => 'required|after:2000',
            'old_month' => 'required',
            'old_day' => 'required',
            'role' => 'required',
            'password' => 'required|regex:/^[a-zA-Z0-9]+$/|between:8,30|confirmed:password',
            'birth_day' => 'date|before:today'
        ];
    }
}