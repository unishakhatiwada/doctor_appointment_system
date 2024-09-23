<?php

namespace Database\Factories;

use App\Models\Department;
use App\Models\District;
use App\Models\Doctor;
use App\Models\Municipality;
use App\Models\Province;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Doctor>
 */
class DoctorFactory extends Factory
{
    protected $model = Doctor::class;

    public function definition(): array
    {
        $adDate = $this->faker->date('Y-m-d');
        $bsDate = $this->faker->date('Y-m-d');

        // Fetch all provinces, districts, and municipalities
        $provinces = DB::table('provinces')->get();
        $districts = DB::table('districts')->get();
        $municipalities = DB::table('municipalities')->get();

        // Create an empty array to hold the structured location data
        $locationData = [];

        // Loop through provinces and group districts and municipalities accordingly
        foreach ($provinces as $province) {
            $locationData[$province->id] = [
                'districts' => [],
            ];

            foreach ($districts->where('province_id', $province->id) as $district) {
                $locationData[$province->id]['districts'][$district->id] = [
                    'municipalities' => [],
                ];

                foreach ($municipalities->where('district_id', $district->id) as $municipality) {
                    $locationData[$province->id]['districts'][$district->id]['municipalities'][] = $municipality->id;
                }
            }
        }

        // Randomly select a province
        $provinceId = $this->faker->randomElement(array_keys($locationData));

        // Randomly select a district within the selected province
        $districtId = $this->faker->randomElement(array_keys($locationData[$provinceId]['districts']));

        // Randomly select a municipality within the selected district
        $municipalityId = $this->faker->randomElement($locationData[$provinceId]['districts'][$districtId]['municipalities']);

        return [
            'name' => $this->faker->name,
            'address' => $this->faker->address,
            'gender' => $this->faker->randomElement(['male', 'female', 'others']),
            'phone' => $this->faker->unique()->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'date_of_birth_ad' => $adDate,
            'date_of_birth_bs' => $bsDate,
            'marital_status' => $this->faker->randomElement(['married', 'single', 'divorced', 'widow']),
            'status' => 'active',
            'department_id' => Department::factory(),
            'province_id' => $provinceId,
            'district_id' => $districtId,
            'municipality_id' => $municipalityId,
        ];
    }
}
