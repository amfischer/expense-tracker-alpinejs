<?php

use App\Http\Controllers\ExpenseController;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Tag;
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

test('store/update expense will validate the category_id belongs to authenticated user', function () {
    $category = Category::factory()->create();

    login();

    $user = Auth::user();

    expect($user->id)->not->toEqual($category->user->id);

    post(action([ExpenseController::class, 'store']), [
        'category_id' => $category->id,
    ])->assertSessionHasErrors([
        'category_id' => 'The selected category id is invalid.',
    ]);
});

test('store/update expense will validate tags belong to authenticated user', function () {
    $tags = Tag::factory(3)->create();
    $tagIds = [];

    login();

    $user = Auth::user();

    foreach ($tags as $tag) {
        $tagIds[] = $tag->id;

        expect($user->id)->not->toEqual($tag->user->id);
    }

    post(action([ExpenseController::class, 'store']), [
        'tags' => $tagIds,
    ])->assertSessionHasErrors([
        'tags.0' => 'The selected tags.0 is invalid.',
        'tags.1' => 'The selected tags.1 is invalid.',
        'tags.2' => 'The selected tags.2 is invalid.',
    ]);

});
