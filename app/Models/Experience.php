<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'doctor_id', 'job_title', 'type_of_employment', 'health_care_name',
        'health_care_location', 'start_date_bs', 'start_date_ad', 'end_date_bs',
        'end_date_ad', 'additional_detail'
    ];

    public function doctor(): BelongsTo
    {
        return $this->belongsTo(Doctor::class);
    }
}
