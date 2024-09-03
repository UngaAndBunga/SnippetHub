<div class="m-6 mb-0 pb-6">
    <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4 center text-center">
        {{ __('Trending Posts') }}
    </div>
    @foreach ($postsWithTags as $item)
        <x-post :post="$item['post']" :tags="$item['tags']" />
    @endforeach
</div>
