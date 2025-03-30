<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $batchSize = 1000; // Insert 1,000 users per batch
        $totalBatches = 100; // 100,000 users in total

        if ($this->command) { // Ensure command object exists
            $this->command->info("Starting user seeding...");
        }

        for ($i = 0; $i < $totalBatches; $i++) {
            User::factory()->count($batchSize)->create();

            if ($this->command) {
                $this->command->info("Inserted " . (($i + 1) * $batchSize) . " users...");
            }
        }

        if ($this->command) {
            $this->command->info("User seeding completed!");
        }
    }
}
