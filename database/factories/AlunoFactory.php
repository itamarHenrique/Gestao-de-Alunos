<?php

namespace Database\Factories;

use App\Models\Aluno;
use App\Models\Endereco;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Aluno>
 */
class AlunoFactory extends Factory
{

    protected $model = Aluno::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'primeiro_nome' => $this->faker->firstName(),
            'sobrenome' => $this->faker->lastName(),
            'email' => $this->faker->unique->safeEmail(),
            'RA' => $this->faker->unique()->randomNumber(8),
            'unidade_de_ensino' => 'Unime - FCT Lauro de Freitas',
            'celular' => $this->faker->phoneNumber()
        ];
    }



}
