<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Podcast;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Episode>
 */
class EpisodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'podcast_id' => \App\Models\Podcast::factory(),
            'title' => $this->faker->sentence(),
            'audio_path' => 'episodes/sample.mp3',
            'duration' => rand(300, 1800),
        ];
    }
}
