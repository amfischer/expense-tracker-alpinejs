<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Rules\AlphaSpace;
use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class StoreExpenseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'payee'            => ['required', new AlphaSpace],
            'amount'           => 'required|decimal:0,2',
            'fees'             => 'nullable|decimal:0,2',
            'currency'         => ['required', Rule::in(Currency::names())],
            'transaction_date' => 'required|date',
            'effective_date'   => 'required|date',
            'category_id'      => [
                'required',
                'numeric',
                Rule::exists('categories', 'id')->where(fn (Builder $query) => $query->where('user_id', Auth::user()->id)),
            ],
            'tags'             => 'array',
            'tags.*'           => Rule::in(Auth::user()->tagIds),
            'notes'            => 'nullable',
        ];
    }
}
