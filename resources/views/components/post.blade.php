@props(['post', 'tags'])

<div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h3 class="text-lg font-semibold">{{ $post['post_name'] }}</h3>
        <div x-data="{ showText: false }" class="relative">
            <div x-ref="content"
                 :class="showText ? 'prose dark:prose-dark' : 'prose dark:prose-dark max-h-[15em] overflow-hidden'"
                 class="prose dark:prose-dark">
                <pre class="scroll-auto overflow-auto" x-ref="pre">{{ $post->post_content }}</pre>
            </div>
            <button @click="showText = !showText"
                    x-text="showText ? 'Show Less' : 'Show More'"></button>
        </div>

        <div class="mt-2">
            @foreach ($tags as $tag)
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                    {{ $tag }}
                </span>
            @endforeach
        </div>
        <div class="mt-2">
            @livewire('vote', ['post' => $post])
        </div>
    </div>
</div>
