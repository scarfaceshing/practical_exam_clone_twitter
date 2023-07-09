<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'max:100', 'regex:/^[a-zA-Z| ]+$/u'],
            'username' => ['required', 'max:50', 'min:5', 'regex:/^[a-z0-9]+$/u'],
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required'],
        ];
    }
}
