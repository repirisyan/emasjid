<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class KontakFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->name(),
            'email' => $this->faker->email(),
            'subject' => $this->faker->word(),
            'pesan' => $this->faker->paragraph(),
            'status' => 1,
            'created_at' => now(),
        ];
    }
}
