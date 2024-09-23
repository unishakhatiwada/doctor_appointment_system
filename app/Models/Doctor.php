<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Doctor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'address', 'password', 'confirm_password',
        'phone', 'email', 'status',
        'date_of_birth_ad', 'date_of_birth_bs',
        'province_id', 'district_id', 'municipality_id',
        'department_id',
    ];

    public function department():BelongsTo
    {
        return $this->belongsTo(Department::class, 'department_id');
    }

    public function experiences():HasMany
    {
        return $this->hasMany(Experience::class);
    }

    public function educations():HasMany
    {
        return $this->hasMany(Education::class);
    }
}
