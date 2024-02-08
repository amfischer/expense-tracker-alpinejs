<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit Expense') }}
        </h2>
    </x-slot>

    @session('message')
        <div class="pt-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <x-auth-session-status class="text-center text-lg" :status="$value" />
            </div>
        </div>
    @endsession

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="sm:flex sm:items-center sm:justify-end">
                <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                      <x-button-link :href="route('expenses.index')">
                          {{ __('Back') }}
                      </x-button-link>
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @include('expense.partials.edit-expense-form')
            </div>

        </div>
    </div>
</x-app-layout>
