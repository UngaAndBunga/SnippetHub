<div class="search-container center mx-auto max-w-4xl px-4 py-6">
    <div class="relative">
        <input wire:model.live="helpme" type="text" class="w-full px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg focus:outline-none focus:ring" placeholder="Search...">
    </div>
<div class="search-results">
    @if(!empty($searchResults))
    
        <ul class="mt-4 w-full max-w-4xl mx-auto border border-gray-300 bg-white rounded-lg shadow-lg">
            @foreach($searchResults as $result)
                <li class="p-4 border-b border-gray-300">
                    @if(!empty($postTags[$result['id']]))
                        <a href="{{ route('posts.show', ['id' => $result['id']]) }}" class="block hover:bg-gray-100">
                            <h3 class="text-lg font-semibold">{{ $result['post_name'] }}</h3>
                            <div class="mt-2">
                                @foreach($postTags[$result['id']] as $tag)
                                    <span class="inline-block bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700 mr-2">
                                        {{ $tag }}
                                    </span>
                                @endforeach
                            </div>
                        </a>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif


    @if(!empty($userResults))
        <ul class="mt-4 w-full max-w-4xl mx-auto border border-gray-300 bg-white rounded-lg shadow-lg">
            @foreach($userResults as $result)
                <li class="p-4 border-b border-gray-300">
                    <a href="{{ route('users.show', ['id' => $result['id']]) }}" class="block hover:bg-gray-100">
                        <h3 class="text-lg font-semibold">{{ $result['name'] }}</h3>
                        <p class="text-gray-600">{{ $result['email'] }}</p>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    @if(empty($searchResults) && empty($userResults) && $helpme)
        <div class="mt-4 w-full max-w-4xl mx-auto text-gray-600">
            No results found for "{{ $helpme }}"
        </div>
    @endif
</div>
</div>
