<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new User([
            'name'                      => $row['name'],
            'id_number'                 => $row['id_number'],
            'subscription_number'       => $row['subscription_number'],
            'email'                     => $row['email'],
            'mobile'                    => $row['mobile'],
            'address'                   => $row['address'],
            'password'                  => $row['password'],
            'admin_id'                  => 2
        ]);
    }
}
