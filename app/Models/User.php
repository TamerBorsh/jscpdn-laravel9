<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guarded = [];

    protected $hidden  = ['map_latitude', 'map_longitude', 'admin_id', 'email_verified_at', 'remember_token', 'updated_at'];


    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = Hash::make($value);
    }

    public function userTreatments()
    {
        return $this->hasMany(UserTreatment::class);
    }


    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getStateAttribute()
    {
        return $this->user_status ? 'نشط' : 'غير نشط';
    }
}
