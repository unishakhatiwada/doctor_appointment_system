<?php

namespace Database\Factories;

use App\Models\Doctor;
use App\Models\Schedule;
use Illuminate\Database\Eloquent\Factories\Factory;

class ScheduleFactory extends Factory
{
    protected $model = Schedule::class;

    public function definition()
    {
        return [
            'doctor_id' => Doctor::factory(),
            'day_of_week' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']),
            'start_time' => $this->faker->time('H:i:s', '08:00:00'),
            'end_time' => $this->faker->time('H:i:s', '17:00:00'),
            'appointment_duration' => $this->faker->numberBetween(15, 60),
            'is_active' => $this->faker->boolean(90),
        ];
    }
}
