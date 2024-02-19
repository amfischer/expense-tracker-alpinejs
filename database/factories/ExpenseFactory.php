<?php

namespace Database\Factories;

use App\Enums\Currency;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Tag;
use App\Models\User;
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
        'Digital Ocean',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'          => User::factory(),
            'category_id'      => function (array $attr) {
                return Category::factory()->set('user_id', $attr['user_id']);
            },
            'payee'            => $this->faker->randomElement($this->payees),
            'amount'           => $this->faker->randomFloat(2, 1, 1000), // between $1 USD - $1,000 USD
            'fees'             => $this->faker->randomFloat(2, 1, 10),
            'transaction_date' => $this->faker->dateTimeBetween('-1 year'),
            'effective_date'   => function (array $attr) {
                return $attr['transaction_date'];
            },
            'currency'         => Currency::USD(),
        ];
    }

    /**
     * add tags to the expense
     *
     * think this requires the tags to be created, not sure it will work with ->make()
     */
    public function withTags(int $count = 1): Factory
    {
        return $this->afterCreating(function (Expense $expense) use ($count) {
            $tags = Tag::factory($count)->create(['user_id' => $expense->user_id]);

            $expense->tags()->attach($tags);
        });
    }
}
