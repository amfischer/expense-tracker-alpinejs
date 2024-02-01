<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Expenses') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 sm:px-6 lg:px-8">

                <div class="sm:flex sm:items-center sm:justify-end">
                  {{-- <div class="sm:flex-auto"> --}}
                    {{-- <h1 class="text-xl font-semibold leading-6 text-gray-900 dark:text-gray-100">Expenses Table</h1> --}}
                    {{-- <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">A list of all expenses in your account including amount, date, and payee.</p> --}}
                  {{-- </div> --}}
                  <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <x-button-link :href="route('expenses.create')">
                            {{ __('Add expense') }}
                        </x-button-link>
                  </div>
                </div>

                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <table class="min-w-full divide-y divide-gray-300">

                                <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 dark:text-gray-100 sm:pl-0">Payee</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">Category</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">Tags</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">Amount</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">Date</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 dark:text-gray-100">Notes</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                            <span class="sr-only">Edit</span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-200">
                                    
                                        @foreach ($expenses as $expense)
                                        <tr>

                                            
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{$expense->payee}}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{$expense->category->name}}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{$expense->tagsPretty}}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{$expense->amount}}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{$expense->transaction_date->format('Y-m-d')}}</td>
                                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">{{$expense->notes}}</td>

                                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                                <a href="#" class="text-white hover:text-gray-400">Edit</a>
                                            </td>
                                        </tr>
                                        @endforeach
                                        {{-- <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 dark:text-gray-100 sm:pl-0">Lindsay Walton</td> --}}
                                        {{-- <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">lindsay.walton@example.com</td> --}}
                                        {{-- <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 dark:text-gray-300">Member</td> --}}
                                        {{-- <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0"> --}}
                                            {{-- <a href="#" class="text-white hover:text-gray-400">Edit<span class="sr-only">, Lindsay Walton</span></a> --}}
                                        {{-- </td> --}}
                        
                                </tbody>

                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
