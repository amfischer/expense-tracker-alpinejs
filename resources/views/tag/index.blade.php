<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tags') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="px-4 sm:px-6 lg:px-8">

                <div class="sm:flex sm:items-center sm:justify-end">
                  <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                        <x-buttons.link :href="route('tags.index')">
                            {{ __('Add tag') }}
                        </x-buttons.link>
                  </div>
                </div>

                <div class="mt-8 flow-root">
                    <div class="-mx-4 -my-2 sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">

                            <ul role="list" class="mt-3 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-4">
                                @foreach ($tags as $tag)
                                    <li>{{$tag->name}}</li>
                                @endforeach
                            </ul>

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</x-app-layout>
