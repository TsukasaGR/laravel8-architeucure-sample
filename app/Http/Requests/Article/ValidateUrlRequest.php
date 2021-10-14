<?php

namespace App\Http\Requests\Article;

use App\Rules\UniqueUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ValidateUrlRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'url' => ['required', 'active_url', new UniqueUrl],
        ];
    }

    /**
     * バリデーション実行前のデータ整形
     *
     * @return void
     */
    public function prepareForValidation()
    {
        // URLはGETで渡すためencodeしてリクエストしているが、バリデーションチェックはencode前の状態で行う
        $this->merge(['url' => urldecode($this->get('url'))]);
    }
}
