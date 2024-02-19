<section class="space-y-6">
    <header>
        <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('Delete Expense') }}
        </h2>
    </header>

    <x-buttons.danger
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-expense-deletion')"
    >{{ __('Delete Expense') }}</x-buttons.danger>

    <x-modal name="confirm-expense-deletion" max-width="md" focusable>
        <form method="post" action="{{ route('expenses.delete', $expense) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-right text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this expense?') }}
            </h2>

            <div class="mt-6 flex justify-end">
                <x-buttons.secondary x-on:click="$dispatch('close')">
                    {{ __('No') }}
                </x-buttons.secondary>

                <x-buttons.danger class="ms-3">
                    {{ __('Yes, delete') }}
                </x-buttons.danger>
            </div>
        </form>
    </x-modal>
</section>
