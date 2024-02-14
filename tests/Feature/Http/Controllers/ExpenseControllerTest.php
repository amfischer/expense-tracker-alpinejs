<?php

use App\Http\Controllers\ExpenseController;
use App\Models\Category;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\post;

it('can show expenses', function () {
    $expense = Expense::factory()->create();

    $this->get('/expenses')
        ->assertRedirect(route('login'));

    login($expense->user);

    $this->get('/expenses')
        ->assertSee($expense->payee)
        ->assertSee($expense->total);
});

it("will not show another user's expenses", function () {
    $expenseFromDifferentUser = Expense::factory()->create();

    login();

    $user = Auth::user();

    $this->get('/expenses')
        ->assertOk()
        ->assertDontSee($expenseFromDifferentUser->payee)
        ->assertDontSee($expenseFromDifferentUser->total);

    $this->assertDatabaseMissing('expenses', [
        'user_id' => $user->id,
    ]);
});

it('will validate the category_id owner on the expense create/edit form', function () {
    $category = Category::factory()->create();

    login();

    post(action([ExpenseController::class, 'store']), [
        'payee'            => 'Walmart',
        'amount'           => '22.22',
        'fees'             => '0.89',
        'currency'         => 'USD',
        'transaction_date' => '2024-01-01',
        'effective_date'   => '01/10/2024',
        'category_id'      => $category->id,
        'tags'             => [],
    ])->assertSessionHasErrors([
        'category_id' => 'The selected category id is invalid.',
    ]);
});
