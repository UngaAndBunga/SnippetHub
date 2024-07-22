
<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h3 class="text-lg font-semibold">{{ $post->post_name }}</h3>
        <div x-data="{ showText: false }" class="relative">
            <div x-ref="content" :class="{'max-h-[15em] overflow-hidden': !showText}" class="prose dark:prose-dark">
                <pre x-ref="pre">{{ $post->post_content }}</pre>
            </div>
            <button @click="showText = !showText" x-text="showText ? 'Show Less' : 'Show More'"></button>
        </div>
        <div class="mt-2">
            @foreach ($tags as $tag)
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                    {{ $tag }}
                </span>
            @endforeach
        </div>
    </div>
</div>
