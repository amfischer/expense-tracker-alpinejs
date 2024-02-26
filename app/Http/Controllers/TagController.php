<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Rules\AlphaSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(Request $request): View
    {
        $tags = Tag::withCount('expenses')->where(['user_id' => $request->user()->id])->get();

        // $tags = [$tags[0]];

        return view('tag.index', compact('tags'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', new AlphaSpace],
        ]);

        $request->user()->tags()->create($validated);

        return back()->with('message', 'Tag successfully created.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Tag $tag)
    {
        Gate::authorize('update', $tag);

        $validated = $request->validate([
            'name' => ['required', new AlphaSpace],
        ]);

        $tag->update($validated);

        return back()->with('message', 'Tag successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Tag $tag)
    {
        Gate::authorize('delete', $tag);

        $tag->loadCount('expenses');

        if ($tag->expenses_count !== 0) {
            $count = $tag->expenses_count;

            return back()->with('message', 'Tag is linked to '.$count.' expenses. Remove these relationships before deleting.');
        }

        $tag->delete();

        return redirect()->route('expenses.index')->with('message', 'Tag successfully deleted.');
    }
}
