<?php

namespace Database\Seeders;

use App\Models\Stores;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Stores::factory(10)->create();

        Stores::factory()->create([
            'name' => 'Test Stores',
            'email' => 'test@example.com',
        ]);
    }
}
