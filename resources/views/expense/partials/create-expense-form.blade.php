<section>
    {{-- <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Add Expense') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __("Create a new expense.") }}
        </p>
    </header> --}}

    <form method="post" action="{{ route('expenses.store') }}" class="max-md:space-y-6 md:flex md:flex-wrap">
        @csrf

        <div class="space-y-6 md:w-1/2 md:pr-5 md:flex md:flex-col md:justify-between">
            <div>
                <x-input-label for="payee" :value="__('Payee')" />
                <x-text-input id="payee" name="name" type="text" class="mt-1 block w-full" :value="old('payee')" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('payee')" />
            </div>

            <div>
                <x-input-label for="amount" :value="__('Amount')" />
                <x-text-input id="amount" name="amount" type="number" step=".01" class="mt-1 block w-full" :value="old('amount')" placeholder="0.00" required />
                <x-input-error class="mt-2" :messages="$errors->get('amount')" />
            </div>

            <div>
                <x-input-label for="fees" :value="__('Fees')" />
                <x-text-input id="fees" name="fees" type="number" step=".01" class="mt-1 block w-full" :value="old('fees')" placeholder="0.00" />
                <x-input-error class="mt-2" :messages="$errors->get('fees')" />
            </div>

            <div>
                <x-input-label for="currency" :value="__('Currency')" />
                <x-forms.select-menu id="currency" name="currency" class="mt-1 block w-full" :value="old('currency')" :options="$currencies" required />
                <x-input-error class="mt-2" :messages="$errors->get('currency')" />
            </div>

            <div>
                <x-input-label for="date" :value="__('Transaction Date')" />
                <x-text-input id="date" name="date" type="date" class="mt-1 block w-full" :value="old('date')" required />
                <x-input-error class="mt-2" :messages="$errors->get('date')" />
            </div>
        </div>

        <div class="space-y-6 md:w-1/2 md:pl-5 md:flex md:flex-col md:justify-between">        
            <div>
                <x-input-label for="category" :value="__('Category')" />
                <x-forms.select-menu id="category" name="category" class="mt-1 block w-full" :value="old('category')" :options="$user->categories" required />
                <x-input-error class="mt-2" :messages="$errors->get('category')" />
            </div>

            <div>
                <x-input-label for="tag" :value="__('Tags')" />
                <x-forms.select-menu id="tags" name="tags[]" class="mt-1 block w-full" :value="old('tags')" :options="$user->categories" multiple size="5" />
                <x-input-error class="mt-2" :messages="$errors->get('tags')" />
            </div>

            <div>
                <x-input-label for="notes" :value="__('Notes')" />
                <x-forms.textarea id="notes" name="notes" class="mt-1 block w-full" :value="old('notes')" rows="5" />
                <x-input-error class="mt-2" :messages="$errors->get('notes')" />
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 w-full mt-10">
            <x-primary-button>{{ __('Save') }}</x-primary-button>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
