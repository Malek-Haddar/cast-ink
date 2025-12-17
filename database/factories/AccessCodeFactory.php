<?php

namespace Database\Factories;
use App\Models\Podcast;
use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccessCode>
 */
class AccessCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
         return [
            'podcast_id' => Podcast::factory(), // assign a random podcast
            'code' => strtoupper($this->faker->unique()->bothify('CODE-####')),
            'is_used' => false,
        ];
    }
}
