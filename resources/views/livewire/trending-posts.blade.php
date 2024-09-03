<div class="lg:m-6 lg:mb-0 pb-10 sm:m-0">
    <h1 class="font-semibold text-3xl text-gray-200 leading-tight mb-4 center text-center">
        {{ __('Trending Posts') }}
    </h1>
    @foreach ($postsWithTags as $item)
        <x-post :post="$item['post']" :tags="$item['tags']" />
    @endforeach
</div>
