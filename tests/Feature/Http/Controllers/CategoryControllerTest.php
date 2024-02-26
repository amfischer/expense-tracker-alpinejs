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
    $categoryRestricted = Category::factory()->create();

    login();

    $user = Auth::user();

    $this->get(route('expenses.index'))
        ->assertOk()
        ->assertDontSee($categoryRestricted->payee)
        ->assertDontSee($categoryRestricted->total);

    $this->assertDatabaseMissing('expenses', [
        'user_id' => $user->id,
    ]);
});

test('users can create new categories', function () {

    $formData = Category::factory()->make(['user_id' => $this->user->id])->toArray();

    $this->post(route('categories.store'), $formData);

    $this->assertDatabaseHas('categories', $formData);
});

test('users can update existing categories', function () {

    $category = Category::factory()->create(['user_id' => $this->user->id]);

    $this->assertModelExists($category);

    $formData = Category::factory()->make(['user_id' => $this->user->id])->toArray();

    $this->put(route('categories.update', $category), $formData);

    $this->assertDatabaseHas('categories', $formData);
});

test('users can delete existing categories', function () {
    $category = Category::factory()->create(['user_id' => $this->user->id]);

    $this->assertModelExists($category);

    $this->delete(route('categories.delete', $category));

    $this->assertModelMissing($category);
    $this->assertDatabaseMissing('categories', ['id' => $category->id]);

});

it('will block category deletion if the category is linked to any expenses', function () {
    $category = Category::factory()->create(['user_id' => $this->user->id]);
    $expenses = Expense::factory(2)->create(['user_id' => $this->user->id, 'category_id' => $category->id]);

    $this->delete(route('categories.delete', $category))
        ->assertRedirect()
        ->assertSessionHas('message', 'category is linked to '.count($expenses).' expenses. Remove these relationships before deleting.');

});

/**
 * AUTHORIZATION TESTS
 */
it('will return a 403 if user attempts to update categories from other accounts', function () {
    $categoryRestricted = Category::factory()->create();

    $this->put(route('categories.update', $categoryRestricted), [])
        ->assertForbidden();
});

it('will return a 403 if user attempts to delete categories from other accounts', function () {
    $categoryRestricted = Category::factory()->create();

    $this->delete(route('categories.delete', $categoryRestricted))
        ->assertForbidden();
});
