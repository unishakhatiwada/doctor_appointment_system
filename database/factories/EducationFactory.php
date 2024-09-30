<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Education;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Education>
 */
class EducationFactory extends Factory
{
    protected $model = Education::class;

    public function definition()
    {
        return [
            'doctor_id' => Doctor::factory(),
            'degree' => $this->faker->randomElement(['+2', 'Bachelor', 'Master', 'PhD']),
            'institute_name' => $this->faker->company,
            'institute_address' => $this->faker->address,
            'faculty' => $this->faker->word,
            'joining_date' => $this->faker->date(),
            'graduation_date' => $this->faker->date(),
            'grade' => $this->faker->randomElement(['1', '2', '3', '4']),
            'additional_detail' => $this->faker->sentence,
            'certificate' => null,
        ];
    }
}
