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
            'number' => $this->faker->randomDigitNotNull,
            'names' => fake()->firstName(),
            'surname_father' => fake()->lastName(),
            'surname_mother' => fake()->lastName(),
            'phone' => $this->faker->phoneNumber,
            'gender' => $this->faker->randomElement(['Masculino', 'Femenino']),
            'address' => $this->faker->streetName,
            'address_number' => $this->faker->randomDigit,
            'barrio' => $this->faker->city,
            'cp' => $this->faker->countryCode,
            'suburb' => $this->faker->city,
            'municipio' => 'San Baltazar Loxicha',
            'estado' => 'Oaxaca',
            'dwelling' => $this->faker->randomElement(['Alquilada', 'Invadida']),
            'dependents' => $this->faker->numberBetween(0, 10),
            'civil_status' => $this->faker->randomElement(['Casado', 'Soltero', 'Divorciado']),
            'curp' => $this->faker->iban,
            'key_ine' => $this->faker->iban,
            'birthday' => $this->faker->date(),
            'job' => $this->faker->jobTitle,
        ];
    }
}
