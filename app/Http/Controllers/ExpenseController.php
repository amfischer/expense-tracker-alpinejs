<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Expense;
use App\Models\Category;
use App\Rules\AlphaSpace;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ExpenseController extends Controller
{
    public function index(Request $request): View
    {
        $expenses = $request->user()->expenses;
        $expenses->load(['category', 'tags']);

        return view('expense.index', compact('expenses'));
    }

    public function create(Request $request): View
    {
        $user = $request->user();

        $categories = $user->categoriesArray;
        $tags = $user->tagsArray;
        $currencies = Expense::$allowedCurrencies;

        return view('expense.create', compact('categories', 'tags', 'currencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'payee' => ['required', new AlphaSpace],
            'amount' => 'required|decimal:0,2',
            'fees' => 'nullable|decimal:0,2',
            'currency' => ['required', Rule::in(array_keys(Expense::$allowedCurrencies))],
            'transaction_date' => 'required|date',
            'effective_date' => 'required|date',
            'category_id' => 'required|numeric',
            'tags' => 'array',
            'notes' => 'nullable',
        ]);

        // convert to 3 letter string from 3 digit code
        $validated['currency'] = Expense::$allowedCurrencies[$validated['currency']];

        // get tags & separate from Expense payload
        $tags = [];
        
        if (isset($validated['tags'])) {
            $tags = $validated['tags'];
            unset($validated['tags']);
        }

        // create expense
        $expense = $request->user()->expenses()->create($validated);

        // create tag relationships
        foreach ($tags as $tagId) {
            $expense->tags()->attach($tagId);            
        }

        $request->session()->flash('message', 'Expense successfully created.');

        return back();
    }

    public function edit(Expense $expense, Request $request): View
    {
        $user = $request->user();

        $categories = $user->categoriesArray;
        $tags = $user->tagsArray;
        $currencies = Expense::$allowedCurrencies;

        return view('expense.edit', compact('expense', 'categories', 'tags', 'currencies'));
    }
}
