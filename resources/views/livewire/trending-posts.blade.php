<div>
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
        {{ __('All Posts') }}
    </h2>
    @foreach ($postsWithTags as $item)
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                <h3 class="text-lg font-semibold">{{ $item['post']->post_name }}</h3>
                
                <div x-data="{ expanded: true, rowLimit: 10}" class="relative">
                    <div x-ref="content" :class="{'max-h-[15em] overflow-hidden': !expanded}" class="prose dark:prose-dark">
                        <pre x-ref="pre" x-html="`{{ nl2br(e($item['post']->post_content)) }}`">{{ $item['post']->post_content }}</pre>
                    </div>
                    <div x-show="content.split('\n').length > rowLimit" class="mt-2 text-center">
        <span x-show="!expanded" @click="
            expanded = true;
            let pre = $refs.pre;
            pre.style.height = pre.scrollHeight + 'px';
        " class="block bg-gray-200 dark:bg-gray-700 text-sm rounded-md px-3 py-1 mx-auto cursor-pointer">
            {{ __('Show more') }}
        </span>
        <span x-show="expanded" @click="
            expanded = false;
            let pre = $refs.pre;
            pre.style.height = (rowLimit) + 'em';
        " class="block bg-gray-200 dark:bg-gray-700 text-sm rounded-md px-3 py-1 mx-auto cursor-pointer">
            {{ __('Show less') }}
        </span>
    </div>
    {{--todo make it apear shortend first also add upvotes or likes(need to consult boss)--}}
                </div>
                
                <div class="mt-2">
                    @foreach ($item['tags'] as $tag)
                        <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                            {{ $tag }}
                        </span>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.2.2/dist/cdn.min.js" defer></script>
