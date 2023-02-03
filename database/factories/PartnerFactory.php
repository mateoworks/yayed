<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Partner>
 */
class PartnerFactory extends Factory
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
            'names' => fake()->firstName(),
            'surname_father' => fake()->lastName(),
            'surname_mother' => fake()->lastName(),
            'phone' => $this->faker->phoneNumber,
            'address' => $this->faker->address,
            'suburb' => $this->faker->city,
            'curp' => $this->faker->iban,
            'key_ine' => $this->faker->iban,
            'birthday' => $this->faker->date(),
        ];
    }
}
