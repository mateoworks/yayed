<?php

namespace Database\Factories;

use App\Models\Partner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Document>
 */
class DocumentFactory extends Factory
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
            'type' => $this->faker->randomElement([
                'Acta de nacimiento',
                'Credencial INE',
                'CURP',
                'Licencia conducir',
                'Recibo de luz'
            ]),
            'url' => $this->faker->randomElement([
                'document/acta.png',
                'document/ine.jpg',
            ]),
            'partner_id' => Partner::all()->random(),
        ];
    }
}
