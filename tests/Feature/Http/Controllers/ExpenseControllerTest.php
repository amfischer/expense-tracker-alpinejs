<?php

use App\Models\User;
use App\Models\Expense;

use function Pest\Laravel\actingAs;

beforeEach(function() {
    $this->user = User::factory()->create();
});

it('can show expenses', function () {
    $expense = Expense::factory()->create(['user_id' => $this->user->id]);

    $this->get('/expenses')
        ->assertRedirect(route('login'));

    actingAs($this->user);

    $this->get('/expenses')
        ->assertSee($expense->payee)
        ->assertSee($expense->total);
});

it('will not show another user\'s expenses', function() {
    $expenseFromDifferentUser = Expense::factory()->create();

    actingAs($this->user);

    $this->get('/expense')
        ->assertDontSee($expenseFromDifferentUser->payee)
        ->assertDontSee($expenseFromDifferentUser->total);
    
    $this->assertDatabaseMissing('expenses', [
        'user_id' => $this->user->id
    ]);
});
