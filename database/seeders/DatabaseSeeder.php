<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Podcast;
use App\Models\Episode;
use App\Models\AccessCode;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $podcasts = Podcast::factory()
            ->count(5)
            ->has(Episode::factory()->count(8))   // each podcast has 8 episodes
            ->create();

        // Generate access codes attached to the created podcasts
        $podcasts->each(function (Podcast $podcast) use ($user) {
            // create 8 unused + 2 already used codes per podcast
            AccessCode::factory()->count(8)->for($podcast)->create();
            AccessCode::factory()->count(2)->for($podcast)->state([
                'is_used' => true,
                'used_by' => $user->id,
            ])->create();
        });
    }
}
