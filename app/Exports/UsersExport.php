<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class UsersExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $user = User::select('id_number', 'subscription_number', 'name', 'email', 'mobile', 'address')
            ->whereAdmin_id(auth('admin')->user()->id)
            ->orderByDesc('id')->get();
        return  $user;

        // return User::all();
    }

    public function map($user): array
    {
        return [
            $user->name,
            $user->id_number,
            $user->subscription_number,
            $user->email,
            $user->mobile,
            $user->address,
        ];
    }

    public function headings(): array
    {
        return [
            'الاسم', 'رقم الهوية', 'رقم الاشتراك', 'الايميل', 'رقم الاتصال', 'العنوان'
        ];
    }
}
