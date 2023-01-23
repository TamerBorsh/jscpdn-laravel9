<?php

namespace App\Http\Requests\User;

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
            'name'                      => ['required', 'string', 'min:3'],
            'role_id'                   => ['required'],
            'id_number'                 => ['required', 'numeric', 'digits:9', "unique:users,email," . $this->user->id],
            'email'                     => ['required', 'email', "unique:users,email," . $this->user->id],
            'password'                  => ['string', 'min:8'],
            'mobile'                    => ['required'],
            'address'                   => ['required', 'string'],
            'photo'                     => ['image', 'mimes:jpg,png,jpeg'],
        ];
    }

    public function messages()
    {
        return [
            'name.required'                         => 'حقل الاسم مطلوب',
            'name.min'                              => 'يجب ألا يقل الاسم عن 3 أحرف',
            'id_number.string'                      => 'رقم الهوية مطلوب',
            'id_number.unique'                      => 'رقم الهوية موجود مسبقا',
            'id_number.digits'                      => 'رقم الهوية يجب أن يكون 9 أرقام',
            'subscription_number.unique'            => 'رقم الاشتراك موجود مسبقا',
            'email.required'                        => 'الايميل مطلوب',
            'email.unique'                          => 'الايميل موجود مسبقا',
            'password.required'                     => 'كلمة المرور مطلوبة',
            'password.min'                          => 'يجب أن تتكون كلمة المرور من 8 أحرف على الأقل.',
            'mobile.required'                       => 'رقم الجوال مطلوب',
            'mobile.digits'                         => 'يجب أن يكون رقم الجوال 10 أرقام.',
            'address.required'                      => 'العنوان مطلوب',
            'status_.in'                            => 'الحالة المختارة غير صالحة.',
            'photo.image'                           => 'يجب أن يكون الملف صورة من نوع jpg,png,jpeg',
            'photo.mimes'                           => 'يجب أن يكون الملف صورة من نوع jpg,png,jpeg',
            'photo.max'                             => 'الرجاء رفع صورة بحجم لا يزيد عن 300 كيلو بايت',
        ];
    }
}
