<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Expense>
 */
class ExpenseFactory extends Factory
{
    private $payees = [
        'PedidosYa',
        'Walmart',
        'McDonalds',
        'Digital Ocean'
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'category_id' => Category::factory(),
            'payee' => $this->faker->randomElement($this->payees),
            'tags' => json_encode(['business expense', 'vacation']),
            'amount' => $this->faker->randomFloat(2, 1.07, 1000),
            'fees' => $this->faker->randomFloat(2, 1.07, 100),
            'transaction_date' => $this->faker->dateTimeBetween('-1 year'),
            'currency' => 'USD',
        ];
    }
}
