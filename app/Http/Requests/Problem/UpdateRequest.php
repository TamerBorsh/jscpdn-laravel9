<?php

namespace App\Http\Requests\Problem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'status'        => ['required', 'integer'],
        ];
    }

    
    public function messages()
    {
        return [
            'status.required'               => 'حالة الشكوى مطلوبة',
            'status.integer'                => 'هناك خطأ في البيانات المدخلة',
        ];
    }
}
