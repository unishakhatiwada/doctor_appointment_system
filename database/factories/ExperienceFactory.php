<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Experience;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experience>
 */
class ExperienceFactory extends Factory
{
    protected $model = Experience::class;

    public function definition()
    {
        return [
            'doctor_id' => Doctor::factory(),
            'job_title' => $this->faker->jobTitle,
            'health_care_name' => $this->faker->company,
            'health_care_location' => $this->faker->address,
            'type_of_employment' => $this->faker->randomElement(['full_time', 'part_time', 'contract', 'internship']),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date(),
            'additional_detail' => $this->faker->sentence,
            'certificate' => null,
        ];
    }
}
