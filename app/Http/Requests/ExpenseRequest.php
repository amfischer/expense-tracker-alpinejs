<?php

namespace App\Http\Requests;

use App\Enums\Currency;
use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ExpenseRequest extends FormRequest
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
            'category_id'      => ['required', 'numeric', Rule::in(Auth::user()->categoryIds)],
            'tags'             => 'array',
            'tags.*'           => Rule::in(Auth::user()->tagIds),
            'notes'            => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.in' => 'Invalid category selection.',
            'tags.*.in'      => 'Invalid tag selection.',
        ];
    }
}
