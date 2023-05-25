<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Publisher;
use App\Models\Genre;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->name(),
            'subtitle' => $this->faker->text(),
            'language' => $this->faker->randomElement(['Español', 'Inglés']),
            'page' => $this->faker->numberBetween(50,100),
            'published' => $this->faker->date(),
            'description' => $this->faker->text(1000),
            'genre_id' => Genre::all()->random()->id,
            'publisher_id' => Publisher::all()->random()->id,
        ];
    }
}
