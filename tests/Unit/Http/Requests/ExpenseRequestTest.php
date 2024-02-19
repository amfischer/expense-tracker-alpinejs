<?php

use App\Http\Requests\ExpenseRequest;
use App\Models\Category;
use App\Models\Expense;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

beforeEach(function () {
    login();

    $this->user = Auth::user();

    // authenticated user expense data (but has invalid category)
    $this->requestData = Expense::factory()->make(['user_id' => $this->user->id])->toArray();
});

// VALIDATION TESTS

it('will validate the selected category belongs to the authenticated user', function () {

    $request = new ExpenseRequest();

    /**
     * using valid category
     */
    $validator = Validator::make($this->requestData, $request->rules(), $request->messages());

    expect($validator->passes())->toBeTrue();
    expect($validator->messages()->toArray())->toBeEmpty();

    /**
     * using invalid category
     */
    $this->requestData['category_id'] = Category::factory()->create()->id;

    $validator = Validator::make($this->requestData, $request->rules(), $request->messages());

    expect($validator->fails())->toBeTrue();
    expect($validator->messages()->toArray())->toMatchArray([
        'category_id' => ['Invalid category selection.'],
    ]);

});

it('will validate the selected tags belong to the authenticated user', function () {

    $request = new ExpenseRequest();

    /**
     * using invalid tags
     */
    $tags = Tag::factory(2)->create();
    $tagIds = $tags->map(fn (Tag $tag) => $tag->id)->all();

    $this->requestData['tags'] = $tagIds;

    $validator = Validator::make($this->requestData, $request->rules(), $request->messages());

    expect($validator->fails())->toBeTrue();
    expect($validator->messages()->toArray())->toMatchArray([
        'tags.0' => ['Invalid tag selection.'],
        'tags.1' => ['Invalid tag selection.'],
    ]);

    /**
     * using valid tags
     */
    $tags = Tag::factory(2)->create(['user_id' => $this->user->id]);
    $tagIds = $tags->map(fn (Tag $tag) => $tag->id)->all();

    $this->requestData['tags'] = $tagIds;
    $this->user->refresh();

    $validator = Validator::make($this->requestData, $request->rules(), $request->messages());

    expect($validator->passes())->toBeTrue();
    expect($validator->messages()->toArray())->toBeEmpty();
});
