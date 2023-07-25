<?php

namespace Database\Factories;

use App\Models\Mustahik;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mustahik>
 */
class MustahikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Mustahik::class;

    public function definition(): array
    {
        return [
            'nama_lengkap' => $this->faker->name(),
            'desa' => $this->faker->streetName(),
            'kecamatan' => $this->faker->city(),
            'alamat' => $this->faker->streetAddress(),
            'blok' => $this->faker->buildingNumber(),
            'gender' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'pekerjaan' => $this->faker->jobTitle(),
        ];
    }
}
