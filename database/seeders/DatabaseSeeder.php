<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Expense;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // $this->call([
        //     UserSeeder::class
        // ]);

        $user = User::factory()->create([
            'name' => 'Aaron',
            'email' => 'aaron@example.com',
            'password' => Hash::make('password'),
        ]);

        Expense::factory(10)->create([
            'user_id' => $user->id
        ]);
    }
}
