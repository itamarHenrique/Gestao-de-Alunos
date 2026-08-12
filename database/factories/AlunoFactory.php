<?php

namespace Database\Factories;

use App\Models\Aluno;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

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
            'matricula' => $this->faker->unique()->randomNumber(8),
            'unidade_de_ensino' => $this->faker->randomElement([
                'Universidade Nova Era',
                'Faculdade Estrela do Saber',
                'Centro Universitário Horizonte',
                'Universidade do Vale do Sol',
                'Faculdade Portal do Conhecimento',
                'Instituto de Ensino Superior Cosmos',
                'Universidade Leste do Brasil',
                'Faculdade Áurea',
                'Centro Universitário Alpha',
                'Faculdade Verde Vale',
                'Universidade Global do Saber',
                'Instituto de Educação Avançada',
                'Faculdade São Lucas',
                'Universidade Nova Geração',
                'Centro de Ensino Prisma',
                'Universidade Luminare',
                'Faculdade Pioneira',
                'Universidade Horizonte Azul',
                'Faculdade Cruzeiro do Sul',
                'Instituto Brasileiro de Ensino Superior (IBES)',
                'Faculdade Integração Global',
            ]),
            'celular' => $this->faker->phoneNumber(),
            'password' => Hash::make('password'),
        ];
    }



}
