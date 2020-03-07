<?php

namespace Studiosidekicks\Alfred\User\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use BackAuth;

class UpdateMyAccountRequest extends FormRequest
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
        $user = BackAuth::user();
        return [
            'email' => [
                'required',
                Rule::unique('users')->ignore($user)
            ],
            'first_name' => 'required',
            'last_name' => 'required',
        ];
    }
}