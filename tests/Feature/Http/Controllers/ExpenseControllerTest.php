<?php

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

it("will not show another user's expenses", function() {
    $expenseFromDifferentUser = Expense::factory()->create();

    login();

    $user = Auth::user();

    $this->get('/expenses')
        ->assertOk()
        ->assertDontSee($expenseFromDifferentUser->payee)
        ->assertDontSee($expenseFromDifferentUser->total);
    
    $this->assertDatabaseMissing('expenses', [
        'user_id' => $user->id
    ]);
});
