<?php

namespace Database\Factories;

use App\Models\Loan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
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
            'scheduled_date' => $this->faker->date,
            'made_date' => $this->faker->date,
            'principal_amount' => $this->faker->numberBetween(100, 10000),
            'interest_amount' => $this->faker->numberBetween(100, 2000),
            'observations' => $this->faker->text,
            'loan_id' => Loan::all()->random(),
            'user_id' => User::all()->random(),
        ];
    }
}
