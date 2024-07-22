<div class="center">

    <div class="relative">
        <input wire:model.live="helpme" type="text" class="w-full px-4 py-2 text-gray-700 bg-white border rounded-lg focus:outline-none focus:ring" placeholder="Search...">
    </div>

    @if(!empty($searchResults))
        <ul class="mt-4 border border-gray-300 bg-white rounded-lg shadow-lg">
            @foreach($searchResults as $result)
                <li class="p-4 border-b border-gray-300">
                    @if(!empty($postTags[$result['id']]))
                        <div class="post">
                            <h3>{{ $result['post_name'] }}</h3>
                            <div class="tags">
                                @foreach($postTags[$result['id']] as $tag)
                                    <span class="tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif

    @if(!empty($userResults))
        <ul class="mt-4 border border-gray-300 bg-white rounded-lg shadow-lg">
            @foreach($userResults as $result)
                <li class="p-4 border-b border-gray-300">
                    <div class="user">
                        <h3>{{ $result['name'] }}</h3>
                        <!-- Add more user details here if needed -->
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        @if($helpme)
            <div class="mt-4 text-gray-600">
                No results found for "{{ $helpme }}"
            </div>
        @endif
    @endif
</div>
