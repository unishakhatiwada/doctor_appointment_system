<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\Doctor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Doctor::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name, // Random name for the doctor
            'address' => $this->faker->address, // Random address
            'phone' => $this->faker->unique()->phoneNumber, // Unique phone number
            'email' => $this->faker->unique()->safeEmail, // Unique email address
            'status' => 'active', // Set default status to active
            'department_id' => Department::factory(), // Create and link a new department
        ];
    }
}
