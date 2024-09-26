<?php

namespace Database\Seeders;

use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EducationSeeder extends Seeder
{
    public function run(): void
    {
        Doctor::factory()
            ->hasEducations(3) // Generate 3 education entries for each doctor
            ->create();
    }
}
