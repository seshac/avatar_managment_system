<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        // create a user 
        User::factory()
            ->create([
                'name' => 'Test User',
                'email' => 'test@example.com',
            ]);

        // create the categories, Items, Users that have some items
        Category::factory()
            ->count(11)
            ->sequence(
                ['name' => 'Head', 'position' => 1],
                ['name' => 'Hairs', 'position' => 2],
                ['name' => 'Eyes', 'position' => 3],
                ['name' => 'Lips', 'position' => 4],
                ['name' => 'Neck', 'position' => 5],
                ['name' => 'Torso', 'position' => 6],
                ['name' => 'Hand', 'position' => 7],
                ['name' => 'Vest', 'position' => 8],
                ['name' => 'Pants', 'position' => 9],
                ['name' => 'Shoes', 'position' => 10],
                ['name' => 'Skin', 'position' => 11],
            )
            ->has(Item::factory()
                ->hasAttached(
                    User::factory()->count(5),
                    ['active' => true, 'order' => fake()->unique()->randomNumber()]
                )
                ->count(10))
            ->create();
    }
}
