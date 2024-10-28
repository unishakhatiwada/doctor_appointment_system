<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            ['code' => 'DERM', 'name' => 'Dermatology', 'description' => 'Department of Dermatology.'],
            ['code' => 'ORTHO', 'name' => 'Orthopedic', 'description' => 'Department of Orthopedic Surgery.'],
            ['code' => 'URO', 'name' => 'Urology', 'description' => 'Department of Urology.'],
            ['code' => 'CARD', 'name' => 'Cardiology', 'description' => 'Department of Cardiology.'],
            ['code' => 'NEURO', 'name' => 'Neurology', 'description' => 'Department of Neurology.'],
            ['code' => 'ENT', 'name' => 'ENT', 'description' => 'Department of Ear, Nose, and Throat.'],
            ['code' => 'GASTRO', 'name' => 'Gastroenterology', 'description' => 'Department of Gastroenterology.'],
            ['code' => 'PED', 'name' => 'Pediatrics', 'description' => 'Department of Pediatrics.'],
            ['code' => 'ONCO', 'name' => 'Oncology', 'description' => 'Department of Oncology.'],
            ['code' => 'PSYCH', 'name' => 'Psychiatry', 'description' => 'Department of Psychiatry.'],
            ['code' => 'OBGYN', 'name' => 'Obstetrics and Gynecology', 'description' => 'Department of Obstetrics and Gynecology.'],
            ['code' => 'NEPHRO', 'name' => 'Nephrology', 'description' => 'Department of Nephrology.'],
            ['code' => 'RAD', 'name' => 'Radiology', 'description' => 'Department of Radiology.'],
            ['code' => 'DERM2', 'name' => 'Dermatology Special', 'description' => 'Specialist Dermatology Services.'],
            ['code' => 'PATH', 'name' => 'Pathology', 'description' => 'Department of Pathology.'],
        ];

        // Insert the departments into the database
        foreach ($departments as $department) {
            Department::create($department);
        }
    }
}
