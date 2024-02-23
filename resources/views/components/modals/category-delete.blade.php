<div
    x-data="{
        show: false,
        name: '',
        route: '',
        close() {
            this.show = false
        },
        open(e) {
            this.show = true
            this.name = e.detail.name
            this.route = e.detail.route
        }
    }"
    x-init="$watch('show', value => {
        if (value) {
            document.body.classList.add('overflow-y-hidden');
        } else {
            document.body.classList.remove('overflow-y-hidden');
        }
    })"
    x-on:category-delete.window="open"
    x-on:close-modal.window="$event.detail == show ? show = false : null"
    x-on:close.stop="show = false"
    x-on:keydown.escape.window="show = false"
    x-show="show"
    class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
    style="display: none;"
>
    <div
        x-show="show"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
    >
        <div class="absolute inset-0 bg-gray-500 dark:bg-gray-900 opacity-75"></div>
    </div>

    <div
        x-show="show"
        class="mb-6 bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full max-w-lg sm:mx-auto"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    >
        <form method="post" :action="route" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Are you sure you want to delete this category?') }}
                <br>
            </h2>
            
            <p class="text-2xl font-medium text-gray-900 dark:text-gray-100 py-10 text-center" x-text="name"></p>

            <div class="mt-6 flex justify-end">
                <x-buttons.secondary @click="close">{{ __('No') }}</x-buttons.secondary>
                <x-buttons.danger class="ms-3">{{ __('Yes, delete') }}</x-buttons.danger>
            </div>
        </form>
    </div>
</div>

