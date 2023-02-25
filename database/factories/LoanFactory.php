<?php

namespace Database\Factories;

use App\Models\Partner;
use App\Models\Solicitud;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Loan>
 */
class LoanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $solicitud = Solicitud::all()->random();
        return [
            'id' => $this->faker->uuid,
            'number' => $this->faker->unique()->randomNumber(3),
            'amount' => $this->faker->numberBetween(1000, 50000),
            'amount_letter' => 'Mil pesos',
            'date_made' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'date_payment' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'status' => $this->faker->randomElement(['activo', 'suspendido', 'liquidado']),
            'partner_id' => $solicitud->partner,
            'solicitud_id' => $solicitud,
        ];
    }
}
