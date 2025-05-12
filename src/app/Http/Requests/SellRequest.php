<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SellRequest extends FormRequest
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
        return [
            'product_name' => 'required|string|max:255',
            'description'  => 'required|string|max:1000',
            'image'        => 'required|image|mimes:jpeg,png|max:5120',
            'categories'   => 'required|string',
            'condition'    => 'required|string',
            'price'        => 'required|numeric|min:0',
            'brand' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'product_name.required' => '商品名を入力してください。',
            'description.required'  => '商品説明を入力してください。',
            'description.max'       => '商品説明は1000文字以内で入力してください。',
            'image.required'        => '商品画像をアップロードしてください。',
            'image.image'           => '商品画像は画像ファイルを指定してください。',
            'image.mimes'           => '商品画像はjpegまたはpng形式でアップロードしてください。',
            'categories.required'   => '商品のカテゴリーを選択してください。',
            'condition.required'    => '商品の状態を選択してください。',
            'price.required'        => '商品価格を入力してください。',
            'price.numeric'         => '商品価格は数値で入力してください。',
            'price.min'             => '商品価格は0円以上で入力してください。',
        ];
    }
}
