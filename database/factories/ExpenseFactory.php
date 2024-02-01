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
            'amount' => $this->faker->numberBetween(100, 100000), // between $1 USD - $1,000 USD
            'fees' => $this->faker->numberBetween(10, 10000),
            'transaction_date' => $this->faker->dateTimeBetween('-1 year'),
            'currency' => 'USD',
        ];
    }
}
