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

        // Prepare location data for both permanent and temporary addresses
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

// Randomly select a province, district, and municipality for permanent address
        $permanentProvinceId = $this->faker->randomElement(array_keys($locationData));
        $permanentDistrictId = $this->faker->randomElement(array_keys($locationData[$permanentProvinceId]['districts']));
        $permanentMunicipalityId = $this->faker->randomElement($locationData[$permanentProvinceId]['districts'][$permanentDistrictId]['municipalities']);

// Randomly select a province, district, and municipality for temporary address
        $temporaryProvinceId = $this->faker->randomElement(array_keys($locationData));
        $temporaryDistrictId = $this->faker->randomElement(array_keys($locationData[$temporaryProvinceId]['districts']));
        $temporaryMunicipalityId = $this->faker->randomElement($locationData[$temporaryProvinceId]['districts'][$temporaryDistrictId]['municipalities']);

// Return the generated data
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

            // Permanent address
            'permanent_province_id' => $permanentProvinceId,
            'permanent_district_id' => $permanentDistrictId,
            'permanent_municipality_id' => $permanentMunicipalityId,

            // Temporary address
            'temporary_province_id' => $temporaryProvinceId,
            'temporary_district_id' => $temporaryDistrictId,
            'temporary_municipality_id' => $temporaryMunicipalityId,
        ];

    }
}
