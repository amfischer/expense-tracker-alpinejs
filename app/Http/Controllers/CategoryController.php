<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Rules\AlphaSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = Category::withCount('expenses')->where(['user_id' => $request->user()->id])->get();

        // $categories = [$categories[0]];

        return view('category.index', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => ['required', new AlphaSpace],
            'abbreviation' => ['required', 'between:1,3', 'unique:categories,abbreviation'],
            'color'        => ['required', 'hex_color'],
        ]);

        $request->user()->categories()->create($validated);

        return back()->with('message', 'Category successfully created.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        Gate::authorize('update', $category);

        $validated = $request->validate([
            'name'         => ['required', new AlphaSpace],
            'abbreviation' => ['required', 'between:1,3', Rule::unique('categories')->ignore($category->id)],
            'color'        => ['required', 'hex_color'],
        ]);

        $category->update($validated);

        return back()->with('message', 'Category successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Category $category)
    {
        Gate::authorize('delete', $category);

        $category->loadCount('expenses');

        if ($category->expenses_count !== 0) {
            $count = $category->expenses_count;

            return back()->with('message', 'category is linked to '.$count.' expenses. Remove these relationships before deleting.');
        }
        $category->delete();

        return redirect()->route('expenses.index')->with('message', 'Category successfully deleted.');
    }
}
