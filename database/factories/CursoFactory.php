<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Curso>
 */
class CursoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nome' => $this->faker->unique()->randomElement([
                'Engenharia de Software',
                'Ciência da Computação',
                'Análise e Desenvolvimento de Sistemas',
                'Sistemas de Informação',
                'Engenharia Civil',
                'Engenharia Mecânica',
                'Administração',
                'Direito',
                'Medicina',
                'Psicologia',
                'Arquitetura e Urbanismo',
                'Design Gráfico',
                'Marketing',
                'Recursos Humanos',
                'Contabilidade',
                'Fisioterapia',
                'Enfermagem',
                'Odontologia',
                'Farmácia',
                'Biomedicina',
            ]),
            'formacao' => $this->faker->randomElement([
                'Licenciatura',
                'Graduação',
                'Tecnologo',
                'Pós-graduação',
            ]),
        ];
    }
}