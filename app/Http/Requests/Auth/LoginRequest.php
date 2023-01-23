<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email'             => ['required', 'email'],
            'password'          => ['required', 'string',"min:8"],
        ];
    }
    public function messages()
    {
        return [
            'name.required'                         => 'البريد مطلوب',
            'password.required'                     => 'كلمة المرور مطلوبة',
            'password.min'                          => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل.',
        ];
    }
}
