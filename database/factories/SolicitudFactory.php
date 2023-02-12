<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Solicitud>
 */
class SolicitudFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'folio' => $this->faker->randomNumber,
            'date_solicitud' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'date_payment' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'period' => $this->faker->randomDigit,
            'mount' => $this->faker->numberBetween(1000, 50000),
            'concept' => $this->faker->sentence,
            'condition' => $this->faker->randomElement(['denegado', 'autorizado', 'en proceso']),
            'partner_id' => Partner::all()->random(),
        ];
    }
}
