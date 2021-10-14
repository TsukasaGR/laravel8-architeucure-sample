<?php

namespace App\Http\Requests\User;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Auth;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        /** @var User $loggedInUser */
        $loggedInUser = Auth::user();
        /** @var Route $route */
        $route = $this->route();
        /** @var User $updateUser */
        $updateUser = $route->parameter('user');

        // Policyによる権限制御を行う
        return $loggedInUser->can('update', $updateUser);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email:rfc',
        ];
    }
}
