<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasFactory, HasRoles;

    protected $guarded = [];

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function treatments()
    {
        return $this->hasMany(Treatment::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function clientTreatments()
    {
        return $this->hasMany(ClientTreatment::class);
    }

    public function getStateAttribute()
    {
        return $this->admin_status ? 'نشط' : 'غير نشط';
    }

}
