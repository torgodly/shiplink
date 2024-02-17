<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Branch;
use App\Models\Package;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(2)->create(
            [
                'type' => 'user',
            ]
        );

        Branch::factory(2)->create();

//        \App\Models\User::factory(2)->create(
//            [
//                'type' => 'manager',
//            ]
//        );




//         Branch::factory(10)->create();/

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'type' => 'admin',
        ]);

        Package::factory(100)->create();
    }
}
