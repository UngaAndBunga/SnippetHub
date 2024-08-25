<div>
    @foreach($followedPosts as $item)
    <x-post :post="$item['post']" :tags="$item['tags']" />
    @endforeach
</div>
