<?php

namespace Database\Factories;

use App\Models\Livro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livro>
 */
class LivroFactory extends Factory
{
    protected $model = Livro::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => $this->faker->sentence(3),
            'autor' => $this->faker->name(),
            'editora' => $this->faker->company(),
            'ano' => $this->faker->numberBetween(1980, date('Y')),
            'categoria' => $this->faker->randomElement(['Matemática', 'Literatura', 'História', 'Ciências', 'Tecnologia']),
            'descricao' => $this->faker->paragraph(),
            'arquivo_pdf' => null,
            'quantidade' => $this->faker->numberBetween(1, 5),
        ];
    }
}
