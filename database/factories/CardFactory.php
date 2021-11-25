<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CardFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'card_title' => $this->faker->words(3,true),
            'content' => $this->faker->words(10,true),
            'table_id' => $this->faker->numberBetween(1,50),
            'user_id' => 1,
        ];
    }
}
