<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $index = User::latest()->first();
        $no = $index->id;
        return [
            'name' => $this->faker->name(),
            'TanggalLahir' => $this->faker->date(),
            'TempatLahir' => $this->faker->city(),
            'alamat' => $this->faker->address(),
            'kontak' => $this->faker->phoneNumber(),
            'email' => $this->faker->email(),
            'JenisKelamin' => $this->faker->randomElement(['Laki-laki', 'Perempuan']),
            'role' => 2,
            'id_jabatan' => 0,
            'password' => Hash::make("12345"),
            'picture' => 'default_picture.png',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
