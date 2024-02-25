<?php

use App\Models\Category;
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

