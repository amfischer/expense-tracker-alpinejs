@props([
    'category',
])

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

                    <x-dropdown-link @click.prevent="$dispatch('category-delete', { route: '{{route('categories.delete', $category->id)}}', name: '{{$category->name}}' })">
                        {{ __('Delete') }}
                    </x-dropdown-link>

                </x-slot>
            </x-dropdown>
            
        </div>
    </div>
</li>