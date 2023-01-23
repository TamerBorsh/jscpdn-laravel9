<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequestExcel extends FormRequest
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
            'attachment'        => ['required', 'mimes:xlsx,xls']
        ];
    }
    public function messages()
    {
        return [
            'attachment.required'       => 'يجب رفع ملف للاستيراد',
            'attachment.mimes'          => 'يجب أن يكون الملف المرفق من النوع: xlsx، xls',
        ];
    }
}
