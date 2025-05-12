<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'postal_code' => 'required|regex:/^\d{3}-\d{4}$/',
            'address'     => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image'  => 'nullable|image|mimes:jpeg,png|max:2048',
        ];
    }

    /**
     * カスタムメッセージ
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required'         => 'ユーザー名を入力してください。',
            'postal_code.required'  => '郵便番号を入力してください。',
            'postal_code.regex'     => '郵便番号はハイフンありの8文字（例：123-4567）で入力してください。',
            'address.required'      => '住所を入力してください。',
            'profile_image.image'     => 'プロフィール画像は画像ファイルを選択してください。',
            'profile_image.mimes'     => 'プロフィール画像はjpegまたはpng形式でアップロードしてください。',
            'profile_image.max'       => 'プロフィール画像は2MB以下にしてください。',
        ];
    }
}
