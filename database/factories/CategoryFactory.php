<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    public static $categories = [
        'Utilities',
        'Rent',
        'Investments',
        'Food & Drink',
        'Entertainment',
        'Medical',
        'Fitness',
        'BCP Transfer',
        'Education',
        'Charity',
        'Software',
        'Hardware',
        'Transportation',
        'Travel',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'      => User::factory(),
            'name'         => $this->faker->name,
            'abbreviation' => $this->faker->bothify('??'),
            'color'        => $this->faker->hexColor(),
        ];
    }
}
