<?php

namespace Database\Factories;

use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{

    protected $model = Item::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
            'user_id' => Item::factory(),
            'category' => $this->faker->randomElement(['01', '02']),
            'item_name' => $this->faker->word() . ' ' . $this->faker->numberBetween(50, 500) . 'g',
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(50, 1000),
            'expiry_date' => $this->faker->dateTimeBetween('now', '+2 months'),
            'list_status' => $this->faker->boolean(),
            'image_1' => 'storage/images/test/' . $this->faker->uuid() . '.jpg',
        ];
    }
}
