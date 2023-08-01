<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        Product::factory(10)->create();

        User::factory()->create([
            'email' => 'demo@admin.com',
            'name' => 'Demo Admin',
            'password' => bcrypt('password!'),
            'email_verified_at' => Carbon::now()
        ]);
    }
}
