<?php

namespace Database\Seeders;

use App\Models\Entry;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = User::factory()->create([
            'email' => 'admin@finance-app.test',
            'password' => bcrypt('password'),
        ]);

        Entry::factory()
            ->for($user)
            ->create([
                'label' => 'Groceries',
                'amount' => '-60',
            ]);

        Entry::factory()
            ->for($user)
            ->create([
                'label' => 'Lottery Win',
                'amount' => '10',
            ]);

        Entry::factory()
            ->for($user)
            ->create([
                'label' => 'Car Insurance',
                'amount' => '-500',
                'date' => now()->subDay(),
            ]);

        Entry::factory()
            ->for($user)
            ->create([
                'label' => 'Opening Balance',
                'amount' => '3000',
                'date' => now()->subDays(4),
            ]);
    }
}
