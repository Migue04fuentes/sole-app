<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Genre>
 */
class GenreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->randomElement(['Aventura','Cienci ficción','Bibliográfico','No ficción','Hadas','Gótico','Policíaca','Paranormal','Distópico','Fantasía']),
            'description' => $this->faker->text(100),

        ];
    }
}
