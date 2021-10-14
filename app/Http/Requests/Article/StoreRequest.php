<?php

namespace App\Http\Requests\Article;

use App\Rules\UniqueUrl;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
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
            'categoryId' => 'required|exists:categories,id',
            'title' => 'required',
            'description' => 'required',
        ];
    }
}
