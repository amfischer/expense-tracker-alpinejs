<?php

use App\Models\Category;
use App\Models\Expense;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    login();

    $this->user = Auth::user();
});

it('can show categories', function () {
    $category = Category::factory()->create(['user_id' => $this->user->id]);

    $this->get(route('categories.index'))
        ->assertOk()
        ->assertSee($category->name);
});

it("will not show another user's categories", function () {
    $expenseRestricted = Expense::factory()->create();

    login();

    $user = Auth::user();

    $this->get(route('expenses.index'))
        ->assertOk()
        ->assertDontSee($expenseRestricted->payee)
        ->assertDontSee($expenseRestricted->total);

    $this->assertDatabaseMissing('expenses', [
        'user_id' => $user->id,
    ]);
});
