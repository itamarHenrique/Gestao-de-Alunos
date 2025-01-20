<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Endereco>
 */
class EnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rua' => $this->faker->streetName(),
            'cep' => $this->faker->postcode(),
            'numero_da_casa' => $this->faker->randomNumber(4),
            'bairro' => $this->faker->streetAddress()
        ];
    }
}
