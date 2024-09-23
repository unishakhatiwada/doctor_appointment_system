<?php

namespace Database\Factories;

use App\Models\Department;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Department>
 */
class DepartmentFactory extends Factory
{
    protected $model = Department::class;

    public function definition(): array
    {
        return [
            'code' => strtoupper($this->faker->unique()->lexify('DEPT???')), // Generate unique department codes
            'name' => $this->faker->company, // Random company name as department name
            'description' => $this->faker->sentence, // Random description
        ];
    }
}
