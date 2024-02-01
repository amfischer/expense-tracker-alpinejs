<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Expense;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request): View
    {
        $expenses = $request->user()->expenses;
        $expenses->load('category');

        foreach ($expenses as $key => $value) {
            $value->tags = implode(', ', $value->tags);
        }

        return view('expense.index', compact('expenses'));
    }

    public function create(Request $request): View
    {
        $user = $request->user();
        $user->load('categories');

        $user->categories = $user->categories->reduce(function (array $carry, Category $category) {
            $carry[$category->id] = $category->name;
            return $carry;
        }, []);

        $currencies = Expense::$allowedCurrencies;

        return view('expense.create', compact('user', 'currencies'));
    }

    public function store(Request $request)
    {
        ray($request->all());
        return back();
    }
}
