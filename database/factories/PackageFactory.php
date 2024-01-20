<?php

namespace Database\Factories;

use App\Models\Branch;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sender = User::factory()->create(['type' => 'user']);
        $receiver = User::factory()->create(['type' => 'user']);
        return [
            'code' => 'PKG-' . $this->faker->unique()->numberBetween(100000, 999999),
            'sender_code' => $sender->sender_code,
            'receiver_code' => $receiver->sender_code,
            'sender_branch_id' => Branch::factory()->create()->id,
            'receiver_branch_id' => Branch::factory()->create()->id,
            'weight' => $this->faker->randomFloat(2, 0, 100),
            'height' => $this->faker->randomFloat(2, 0, 100),
            'width' => $this->faker->randomFloat(2, 0, 100),
            'length' => $this->faker->randomFloat(2, 0, 100),
            'fragile' => $this->faker->boolean,
            'hazardous' => $this->faker->boolean,
            'shipping_method' => $this->faker->randomElement(['air', 'sea', 'land']),
            'insurance' => $this->faker->boolean,
            'is_refrigerated' => $this->faker->boolean,
            'description' => $this->faker->sentence,
            'status' => $this->faker->randomElement(['pending', 'Out for Delivery', 'delivered']),
            'payment_method' => $this->faker->randomElement(['cash', 'credit_card', 'paypal']),


        ];
    }
}
