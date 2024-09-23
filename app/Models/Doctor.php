<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'address',
        'password',
        'confirm_password',
        'date_of_birth_ad',
        'date_of_birth_bs',
        'province_id',
        'district_id',
        'municipality_id',
        'phone',
        'email',
        'status',
        'department_id',
    ];
    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }

    public function educations()
    {
        return $this->hasMany(Education::class);
    }
}
