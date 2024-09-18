<?php

namespace App\Models;

use Carbon\Factory;
use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
    ];
    public function doctors()
    {
        return $this->hasMany(Doctor::class, 'department_id');
    }

}
