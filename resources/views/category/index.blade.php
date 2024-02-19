<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Categories') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 sm:px-6 lg:px-8">

                <div class="sm:flex sm:items-center sm:justify-end">
                  <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <x-buttons.link :href="route('categories.index')">
                            {{ __('Add category') }}
                        </x-buttons.link>
                  </div>
                </div>

                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">

                            <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
                                @foreach ($categories as $category)
                                    <li class="col-span-1 flex rounded-md shadow-sm">
                                        <div 
                                            class="flex w-16 flex-shrink-0 items-center justify-center rounded-l-md text-sm font-medium text-white"
                                            style="background-color: {{$category->color}}">
                                            {{ strtoupper($category->abbreviation) }}
                                        </div>
                                        <div class="flex flex-1 items-center justify-between rounded-r-md border-b border-r border-t border-gray-200 bg-white">
                                            <div class="flex-1 px-4 py-2 text-sm">
                                                <p class="font-medium text-gray-900 hover:text-gray-600">{{$category->name}}</p>
                                                <p class="text-gray-500">{{ $category->expenses_count . ' expenses' }}</p>
                                            </div>
                                            <div class="flex-shrink-0 pr-2">

                                                <x-dropdown width="w-36">
                                                    <x-slot name="trigger">
                                                        <x-buttons.fancy-dots />        
                                                    </x-slot>
                                
                                                    <x-slot name="content">
                                                        <x-dropdown-link>
                                                            {{ __('Edit') }}
                                                        </x-dropdown-link>

                                                        <x-dropdown-link x-data x-on:click.prevent="$dispatch('open-modal', 'category-delete-{{$category->id}}')">
                                                            {{ __('Delete') }}
                                                        </x-dropdown-link>

                                                        <x-modal name="category-delete-{{$category->id}}" max-width="md" :teleport="true" focusable>
                                                            <form method="post" action="{{ route('categories.delete', $category) }}" class="p-6">
                                                                @csrf
                                                                @method('delete')
                                                    
                                                                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                                                    {{ __('Are you sure you want to delete this category?') }}
                                                                    <br>
                                                                </h2>
                                                                
                                                                <p class="text-2xl font-medium text-gray-900 dark:text-gray-100 py-10 text-center">{{ $category->name }}</p>
                                                    
                                                                <div class="mt-6 flex justify-between">
                                                                    <x-buttons.secondary x-on:click="$dispatch('close')">{{ __('No') }}</x-buttons.secondary>
                                                                    <x-buttons.danger class="ms-3">{{ __('Yes, delete') }}</x-buttons.danger>
                                                                </div>
                                                            </form>
                                                        </x-modal>
                                
                                                    </x-slot>
                                                </x-dropdown>
                                                
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                            
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
