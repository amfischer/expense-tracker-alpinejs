<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use App\Models\Tag;
use App\Rules\AlphaSpace;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request): View
    {
        $expenses = $request->user()->expenses;
        $expenses->load(['category', 'tags']);

        foreach ($expenses as $e) {
            $tags = [];
            foreach ($e->tags()->get() as $tag) {
                $tags[] = $tag->name;
            }
            $e->tagsPretty = implode(', ', $tags);
        }

        return view('expense.index', compact('expenses'));
    }

    public function create(Request $request): View
    {
        $user = $request->user();
        $user->load(['categories', 'tags']);

        $categories = $user->categories->reduce(function (array $carry, Category $category) {
            $carry[$category->id] = $category->name;
            return $carry;
        }, []);

        $tags = $user->tags->reduce(function (array $carry, Tag $tag) {
            $carry[$tag->id] = $tag->name;
            return $carry;
        }, []);

        $currencies = Expense::$allowedCurrencies;

        return view('expense.create', compact('user', 'categories', 'tags', 'currencies'));
    }

    public function store(Request $request)
    {
        ray($request->all());
        
        $validated = $request->validate([
            'payee' => ['required', new AlphaSpace],
            'amount' => 'required|decimal:2',
            'fees' => 'nullable|decimal:2',
            'currency' => 'required',
            'transaction_date' => 'required|date',
            'category' => 'required',
            'tags' => 'array',
            'notes' => 'nullable',
        ]);

        return back();
    }
}
