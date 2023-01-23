<?php

namespace App\Http\Requests\Problem;

use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'title'             => ['required', 'string', 'max:80'],
            'admin_id'          => ['required'],
            'category'          => ['required', 'integer'],
            'photo'             => ['image', 'mimes:jpg,png,jpeg', 'max:300'],
        ];
    }

    public function messages()
    {
        return [
            'title.required'                => 'الموضوع مطلوب',
            'title.string'                  => 'الموضوع يجب أن يكون نص',
            'title.max'                     => 'يجب ألا يزيد الموضوع عن 80 حرفًا',
            'admin_id.exists'               => 'الجهة المختصة غير موجودة',
            'category.integer'              => 'هناك خطأ في البيانات المدخلة',
            'importance.integer'            => 'هناك خطأ في البيانات المدخلة',
            'photo.image'                   => 'يجب أن يكون الملف صورة من نوع jpg,png,jpeg',
            'photo.mimes'                   => 'يجب أن يكون الملف صورة من نوع jpg,png,jpeg',
            'photo.max'                     => 'الرجاء رفع صورة بحجم لا يزيد عن 300 كيلو بايت',
        ];
    }
}
