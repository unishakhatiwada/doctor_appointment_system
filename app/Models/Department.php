<?php

namespace App\Models;

use Carbon\Factory;
use Database\Factories\DepartmentFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Department extends Model
{
    use HasFactory;
    protected static function newFactory(): DepartmentFactory
    {
        return DepartmentFactory::new();
    }
}
