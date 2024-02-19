<section>

    <form method="post" action="{{ route('expenses.update', $expense) }}" class="max-md:space-y-6 md:flex md:flex-wrap">
        @method('put')
        @csrf

        <div class="space-y-6 md:w-1/2 md:pr-5 md:flex md:flex-col md:justify-between">
            <div>
                <x-input-label for="payee" :value="__('Payee')" />
                <x-text-input id="payee" name="payee" type="text" class="mt-1 block w-full" :value="$expense->payee" required autofocus />
                <x-input-error class="mt-2" :messages="$errors->get('payee')" />
            </div>

            <div>
                <x-input-label for="amount" :value="__('Amount')" />
                <x-text-input id="amount" name="amount" type="number" step=".01" class="mt-1 block w-full" :value="$expense->amount" placeholder="0.00" required />
                <x-input-error class="mt-2" :messages="$errors->get('amount')" />
            </div>

            <div>
                <x-input-label for="fees" :value="__('Fees')" />
                <x-text-input id="fees" name="fees" type="number" step=".01" class="mt-1 block w-full" :value="$expense->fees" placeholder="0.00" />
                <x-input-error class="mt-2" :messages="$errors->get('fees')" />
            </div>

            <div>
                <x-input-label for="currency" :value="__('Currency')" />
                <x-forms.select-menu id="currency" name="currency" class="mt-1 block w-full" :value="$expense->currency" :options="$currencies" required />
                <x-input-error class="mt-2" :messages="$errors->get('currency')" />
            </div>

            <div>
                <x-input-label for="date" :value="__('Transaction Date')" />
                <x-text-input id="date" name="transaction_date" type="date" class="mt-1 block w-full" :value="$expense->transaction_date->format('Y-m-d')" required />
                <x-input-error class="mt-2" :messages="$errors->get('transaction_date')" />
            </div>

            <div>
                <x-input-label for="date" :value="__('Effective Date')" />
                <x-text-input id="date" name="effective_date" type="date" class="mt-1 block w-full" :value="$expense->effective_date->format('Y-m-d')" required />
                <x-input-error class="mt-2" :messages="$errors->get('effective_date')" />
            </div>
        </div>

        <div class="space-y-6 md:w-1/2 md:pl-5 md:flex md:flex-col md:justify-between">        
            <div>
                <x-input-label for="category" :value="__('Category')" />
                <x-forms.select-menu id="category" name="category_id" class="mt-1 block w-full" :options="$categories" :value="$expense->category_id" required />
                <x-input-error class="mt-2" :messages="$errors->get('category')" />
            </div>

            <div>
                <p class="mb-5 font-medium text-sm text-gray-700 dark:text-gray-300">{{ __("Tags") }}</p>

                <div class="md:flex md:items-center md:flex-wrap md:px-3">

                    @foreach ($tags as $id => $name)
                        <div class="flex items-center mb-2 md:w-1/2">
                            <div class="flex h-6 items-center">
                                <x-forms.checkbox id="{{$name}}" name="tags[]" :value="$id" :checked="in_array($id, $expense->tagIds)" class="cursor-pointer" />
                            </div>
                            <div class="ml-3">
                                <x-input-label for="{{$name}}" :value="__($name)" class="cursor-pointer" />
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

            <div>
                <x-input-label for="notes" :value="__('Notes')" />
                <x-forms.textarea id="notes" name="notes" class="mt-1 block w-full" rows="5">
                    {{ $expense->notes }}
                </x-forms.textarea>
                <x-input-error class="mt-2" :messages="$errors->get('notes')" />
            </div>
        </div>

        <div class="flex items-center justify-end gap-4 w-full mt-10">
            <x-buttons.primary>{{ __('Update') }}</x-buttons.primary>

            @if (session('status') === 'profile-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Updated.') }}</p>
            @endif
        </div>
    </form>
</section>
