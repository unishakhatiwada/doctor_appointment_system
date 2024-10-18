<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id', 'degree', 'institute_name', 'institute_address', 'grade',
        'faculty', 'joining_date_bs', 'joining_date_ad', 'graduation_date_bs',
        'graduation_date_ad', 'additional_detail','certificate',
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
