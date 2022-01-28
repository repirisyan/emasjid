<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DistribusiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->address(),
            'jumlah' => $this->faker->numberBetween(1,200),
            'progressDistribusi' => 0,
            'status' => 0,
        ];
    }
}
