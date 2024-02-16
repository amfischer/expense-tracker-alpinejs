<?php

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

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

it('will return a 404 if user attempts to access expenses from other accounts', function () {
    login();

    $expenseRestricted = Expense::factory()->create();

    $this->get(route('expenses.edit', $expenseRestricted))
        ->assertNotFound();
});

it('will return a 403 if user attempts to update expenses from other accounts', function () {
    login();

    $user = Auth::user();

    $expenseRestricted = Expense::factory()->create();

    $formData = Expense::factory()->make([
        'category_id' => Category::factory()->create(['user_id' => $user->id]),
    ])->toArray();

    $this->put(route('expenses.update', $expenseRestricted), $formData)
        ->assertForbidden();
});
