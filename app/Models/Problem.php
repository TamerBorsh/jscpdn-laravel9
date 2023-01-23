<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Problem extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function getStateAttribute()
    {
        if ($this->status == '1') {
            return 'جديد';
        } elseif ($this->status == '2') {
            return 'مستلم';
        } elseif ($this->status == '3') {
            return 'قيد المعالجة';
        } elseif ($this->status == '4') {
            return 'تمت المعالجة';
        } elseif ($this->status == '5') {
            return 'مرفوض';
        } elseif ($this->status == '6') {
            return 'لا يوجد مشكلة';
        }
    }

    public function getCategoriesAttribute()
    {
        if ($this->category == 1) {
            return 'شكوى';
        } elseif ($this->category == 2) {
            return 'اقتراح';
        } elseif ($this->category == 3) {
            return 'استفسار';
        }
    }
}
