<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::create(['name'=>'Admin','email'=>'admin@dev.com','password'=>'12345678','admin_status'=>'1']);
        $admin = Admin::first();
        $admin->assignRole(Role::findById(1, 'admin'));
    }
}