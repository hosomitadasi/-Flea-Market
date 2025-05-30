<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Symfony\Contracts\Service\Attribute\Required;
class ItemRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required',
            'price' => ['required', 'integer'],
            'description' => 'required',
            'image_url' => 'required',
            'categories' => 'required',
            'condition_id' => ['required', 'prohibited_if:condition_id,null'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'price.required' => '商品価格を入力してください',
            'price.integer' => '数値を入力してください',
            'description.required' => '商品説明を入力してください',
            'image_url.required' => '商品画像を選択してください',

            'categories.required' => 'カテゴリーを選択してください',
            'condition_id.required' => '商品状態を選択してください',
            'condition_id.prohibited_if' => '商品状態を選択してください',
        ];
    }
}
