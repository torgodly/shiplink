<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->unique()->randomElement([
                'طرابلس',
                'بنغازي',
                'مصراتة',
                'صبراتة',
                'زليتن',
                'طبرق',
                'الزاوية',
                'غات',
                'الخمس',
                'غدامس',
                'المرج',
                'البيضاء',

            ]),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'manager_id' => User::factory()->create(['type' => 'manager', 'sender_code' => null ,  'receiver_code' => null])->id
        ];
    }
}
