<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail(),
            'budget' => $this->faker->numberBetween(150, 4000),
            'message' => $this->faker->text(200), // password
        ];
    }
}
