<div>
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
        {{ __('All Posts') }}
    </h2>
    @foreach ($postsWithTags as $item)
        <x-post :post="$item['post']" :tags="$item['tags']" />
    @endforeach
    <div id="loading-screen" class="fixed inset-0 flex items-center justify-center bg-white z-50">
        <div class="flex items-center space-x-2">
            <div class="w-4 h-4 bg-blue-500 rounded-full animate-bounce"></div>
            <div class="w-4 h-4 bg-green-500 rounded-full animate-bounce"></div>
            <div class="w-4 h-4 bg-red-500 rounded-full animate-bounce"></div>
        </div>
    </div>
</div>
