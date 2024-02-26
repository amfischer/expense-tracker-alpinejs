<?php

use App\Models\Expense;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

beforeEach(function () {
    login();

    $this->user = Auth::user();
});

it('can show tags', function () {
    $tag = Tag::factory()->create(['user_id' => $this->user->id]);

    $this->get(route('tags.index'))
        ->assertOk()
        ->assertSee($tag->name);
});

it("will not show another user's tags", function () {
    $tagRestricted = Tag::factory()->create();

    $this->get(route('tags.index'))
        ->assertOk()
        ->assertDontSee($tagRestricted->name);

    $this->assertDatabaseMissing('tags', [
        'user_id' => $this->user->id,
    ]);
});

test('users can create new tags', function () {

    $formData = Tag::factory()->make(['user_id' => $this->user->id])->toArray();

    $this->post(route('tags.store'), $formData);

    $this->assertDatabaseHas('tags', $formData);
});

test('users can update existing tags', function () {

    $tag = Tag::factory()->create(['user_id' => $this->user->id]);

    $this->assertModelExists($tag);

    $this->put(route('tags.update', $tag), ['name' => 'new tag name test']);

    $this->assertDatabaseHas('tags', ['name' => 'new tag name test']);
});

test('users can delete existing tags', function () {
    $tag = Tag::factory()->create(['user_id' => $this->user->id]);

    $this->assertModelExists($tag);

    $this->delete(route('tags.delete', $tag));

    $this->assertModelMissing($tag);
    $this->assertDatabaseMissing('tags', ['id' => $tag->id]);

});

it('will block tag deletion if the tag is linked to any expenses', function () {
    $tag = Tag::factory()->create(['user_id' => $this->user->id]);
    $expenses = Expense::factory(2)->create(['user_id' => $this->user->id]);

    foreach ($expenses as $expense) {
        $expense->tags()->attach($tag);
    }

    $this->delete(route('tags.delete', $tag))
        ->assertRedirect()
        ->assertSessionHas('message', 'Tag is linked to '.count($expenses).' expenses. Remove these relationships before deleting.');

});

/**
 * AUTHORIZATION TESTS
 */
it('will return a 403 if user attempts to update tags from other accounts', function () {
    $tagRestricted = Tag::factory()->create();

    $this->put(route('tags.update', $tagRestricted), [])
        ->assertForbidden();
});

it('will return a 403 if user attempts to delete tags from other accounts', function () {
    $tagRestricted = Tag::factory()->create();

    $this->delete(route('tags.delete', $tagRestricted))
        ->assertForbidden();
});

