<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Create a Post') }}
    </h2>
</x-slot>
<form wire:submit.prevent="save">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Title!") }}
                </div>
                <x-text-input wire:model="post_name" id="post_name" type="text" class="mt-1 block w-full" required autofocus />
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Snippet!") }}
                </div>
                <div x-data="{ expanded: false, content: @entangle('post_content'), rowLimit: 10, defaultHeight: '50px' }" x-init="
    $nextTick(() => {
        let textarea = $refs.textarea;
        resizeTextarea(textarea);
        textarea.addEventListener('input', () => resizeTextarea(textarea));
    });
    function resizeTextarea(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = textarea.scrollHeight + 'px';
        checkContentOverflow(textarea);
    }
    function checkContentOverflow(textarea) {
        const lines = textarea.value.split('\n').length;
        if (lines > rowLimit && !expanded) {
            textarea.style.height = (rowLimit) + 'em'; // Adjust height per line overflow
        }
    }
"  >
    <textarea x-ref="textarea" x-model="content" :class="{'overflow-hidden': !expanded, 'overflow-auto': expanded}" class="rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100 resize-none w-full" :style="{ minHeight: defaultHeight }" rows="1" required autofocus></textarea>
    <div x-show="content.split('\n').length > rowLimit" class="mt-2 text-center">
        <span x-show="!expanded" @click="
            expanded = true;
            let textarea = $refs.textarea;
            textarea.style.height = textarea.scrollHeight + 'px';
        " class="block bg-gray-200 dark:bg-gray-700 text-sm rounded-md px-3 py-1 mx-auto cursor-pointer">
            {{ __('Show more') }}
        </span>
        <span x-show="expanded" @click="
            expanded = false;
            let textarea = $refs.textarea;
            textarea.style.height = (rowLimit) + 'em';
        " class="block bg-gray-200 dark:bg-gray-700 text-sm rounded-md px-3 py-1 mx-auto cursor-pointer">
            {{ __('Show less') }}
        </span>
    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Tags (comma-separated)") }}
                </div>
                <div>
                    <input type="text" wire:model.live="tags" placeholder="Enter tags" x-data="{ isOpen: false }" 
                           @focus="isOpen = true" @click.away="isOpen = false" @keydown.escape="isOpen = false"
                           @input="isOpen = true" class="block w-full rounded-md shadow-sm border-gray-300 dark:bg-gray-900 dark:border-gray-700 dark:text-gray-100">
                    <div x-show="isOpen" class="absolute bg-white z-50 mt-2 w-full rounded-md shadow-lg overflow-hidden">
                        @if(!empty($tagSuggestions))
                            <ul>
                            @foreach(array_slice($tagSuggestions, 0, 3) as $suggestion)
                                    <li wire:click="selectTag('{{ $suggestion }}')" class="p-2 cursor-pointer hover:bg-gray-200">{{ $suggestion }}</li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="mt-2">
                        @foreach($selectedTags as $index => $tagName)
                            <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                                {{ $tagName }}
                                <button type="button" wire:click="removeTag({{ $index }})" class="ml-2 text-red-500">&times;</button>
                            </span>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="mt-8">
                <x-primary-button>{{ __('Save') }}</x-primary-button>
            </div>
            @if (session()->has('message'))
                <div class="mt-4 text-green-600 dark:text-green-400">
                    {{ session('message') }}
                </div>
            @endif
        </div>
    </div>
</form>
