<?php

namespace Database\Factories;

use App\Models\CategoryMovement;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movement>
 */
class MovementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'id' => $this->faker->uuid,
            'type' => $this->faker->randomElement(['ingreso', 'egreso']),
            'concept' => $this->faker->sentence(4),
            'amount' => $this->faker->numberBetween(100, 4000),
            'date_movement' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'description' => $this->faker->sentence(6),
            'category_movement_id' => CategoryMovement::all()->random(),
        ];
    }
}
