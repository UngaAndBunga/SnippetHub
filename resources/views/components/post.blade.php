@props(['post', 'tags'])

<div class="dark:bg-gray-800 shadow-sm sm:rounded-lg border rounded-2xl m-6 mb-0 pb-4 w-3/4 mx-auto">
    <div class="text-gray-900 dark:text-gray-100 m-4">
        <h3 class="text-lg font-semibold text-center">{{ $post['post_name'] }}</h3>
        <div x-data="{ showText: false }" class="relative">
            <div x-ref="content"
                 :class="showText ? 'prose dark:prose-dark' : 'prose dark:prose-dark max-h-[15em] overflow-hidden'"
                 class="prose dark:prose-dark">
                <pre class="scroll-auto overflow-auto p-4 rounded-2xl" x-ref="pre">{{ $post->post_content }}</pre>
            </div>
            <button @click="showText = !showText"
                    x-text="showText ? 'Show Less' : 'Show More'"></button>
        </div>

        <div class="mt-2">
            @foreach ($tags as $tag)
                <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 p-4">
                    {{ $tag }}
                </span>
            @endforeach
        </div>
        <div class="mt-2">
            @livewire('vote', ['post' => $post])
        </div>
    </div>
</div>
