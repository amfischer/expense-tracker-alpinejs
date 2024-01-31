<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $expenses = $request->user()->expenses;
        $expenses->load('category');

        foreach ($expenses as $key => $value) {
            $value->tags = implode(', ', $value->tags);
        }

        return view('expense.index', compact('expenses'));
    }
}
