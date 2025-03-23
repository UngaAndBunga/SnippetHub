<div class="bg-gray-800 shadow-sm sm:rounded-lg border rounded-2xl pb-4 my-6 lg:w-3/4 lg:mx-auto lg:mb-6 sm:m-0 sm:w-full">
    <div class="text-gray-100 m-4"
         x-data="{ showText: false, copyContent() { navigator.clipboard.writeText(this.$refs.pre.textContent); } }">
        <div class="w-full flex justify-center">
            <div class="text-2xl text-center font-semibold mb-4 pb-2 border-b-2 w-1/6">{{ $post->post_name }}</div>
        </div>

        <div class="relative">
            <div x-ref="content"
                 :class="showText ? 'prose-dark max-h-[9999px]' : 'prose-dark max-h-[15em] overflow-hidden'"
                 class="prose-dark relative transition-all duration-1000 ">

                <div class="relative">
                    <div x-data="{ copyClick: false, copyContent() {
            navigator.clipboard.writeText($refs.pre.textContent);
            this.copyClick = true;
            setTimeout(() => { this.copyClick = false }, 2000);
        } }"
                         class="absolute top-4 right-4">
                        <button @click="copyContent"
                                x-text="copyClick ? 'Copied!' : 'Copy'"
                                class="text-sm bg-white bg-opacity-30 text-white rounded-full px-3 py-1 focus:outline-none focus:ring-2 focus:ring-green-500 animate-pulse">
                        </button>
                    </div>
                    <pre class="scroll-auto overflow-auto p-4 rounded-2xl transition-all duration-1000 ease-in-out" x-ref="pre">{{ $post->post_content }}</pre>
                </div>
            </div>
            <div class="flex justify-center mt-2">
                <button @click="showText = !showText"
                        x-text="showText ? 'Show Less ↑' : 'Show More ↓'"
                        class="text-sm text-white mt-2"></button>
            </div>
        </div>

        <div class="mt-4">
            @foreach ($tags as $tag)
                <span
                    class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2 p-4">
                    {{ $tag }}
                </span>
            @endforeach
        </div>

        <div class="mt-2">
            @livewire('vote', ['post' => $post])
        </div>
    </div>
</div>
