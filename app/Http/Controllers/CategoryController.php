<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Rules\AlphaSpace;
use Illuminate\Http\Request;
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
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

        $request->session()->flash('message', 'Category successfully created.');

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name'         => ['required', new AlphaSpace],
            'abbreviation' => ['required', 'between:1,3', Rule::unique('categories')->ignore($category->id)],
            'color'        => ['required', 'hex_color'],
        ]);

        $category->update($validated);

        $request->session()->flash('message', 'Category successfully updated.');

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Category $category)
    {
        //
    }
}
