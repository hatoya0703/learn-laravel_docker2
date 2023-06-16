<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBlogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', 'exists:categories,id'], // カテゴリーIDがcategoriesテーブルのidカラムに存在することを確認
            'title' => ['required', 'string', 'max:255'],
            'image' => [
                'nullable', // 省略可
                'file', // アップロードされたファイルであること
                'image', // 画像ファイルであること
                'mimes:jpeg,png,jpg,gif', // MIMEタイプを指定
                'max:2048', // 2Mを超えないこと
                'dimensions:min_width=100,min_height=100,max_width=1000,max_height=1000', // 画像サイズを指定
            ],
            'body' => ['required', 'string', 'max:2000'],
        ];
    }
}
