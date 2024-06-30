<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostFormRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [];

        // 投稿
        if ($this->has('post_title')) {
            $rules['post_title'] = 'required|string|min:1|max:100';
        }
        if ($this->has('post_body')) {
            $rules['post_body'] = 'required|string|min:1|max:5000';
        }
        if ($this->has('comment')) {
            $rules['comment'] = 'required|string|min:1|max:2500';
        }
        if ($this->has('post_category_id')) {
            $rules['post_category_id'] = 'required|integer|exists:sub_categories,id';
        }

        // カテゴリー
        if ($this->has('main_category_name')) {
            $rules['main_category_name'] = 'required|string|min:1|max:100|unique:main_categories,main_category';
        }
        if ($this->has('main_category_id')) {
            $rules['main_category_id'] = 'required|integer|exists:main_categories,id';
        }
        if ($this->has('sub_category_name')) {
            $rules['sub_category_name'] = 'required|string|min:1|max:100|unique:sub_categories,sub_category';
        }

        // return [
        //     // 'post_category_id' => 'required|',
        //     'post_title' => 'required|string|min:1|max:100',
        //     'post_body' => 'required|string|min:1|max:5000',
        //     'comment' => 'required|string|min:1|max:2500',
        // ];

        return $rules;
    }

    public function messages()
    {
        return [
            'post_category_id' => 'サブカテゴリーを選択してください。',
            'post_title.min' => 'タイトルは4文字以上入力してください。',
            'post_title.max' => 'タイトルは50文字以内で入力してください。',
            'post_body.min' => '内容は10文字以上入力してください。',
            'post_body.max' => '最大文字数は500文字です。',
        ];
    }
}