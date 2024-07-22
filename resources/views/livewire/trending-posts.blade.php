<div>
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
        {{ __('All Posts') }}
    </h2>
    @foreach ($postsWithTags as $item)
        <x-post :post="$item['post']" :tags="$item['tags']" />
    @endforeach
</div>
