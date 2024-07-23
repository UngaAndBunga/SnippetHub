<div class="max-w-4xl mx-auto px-4 py-6">
    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h1 class="text-2xl font-semibold">{{ $user->name }}</h1>
            <p class="mt-2 text-lg">{{ $user->email }}</p>
            <!-- Add more user details as needed -->
            @if(Auth::check() && Auth::id() !== $user->id)
                <livewire:follow-button :userId="$user->id" />
            @endif
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
        <div class="p-6 text-gray-900 dark:text-gray-100">
            <h2 class="text-xl font-semibold">Posts by {{ $user->name }}</h2>
            @if($posts->isEmpty())
                <p class="mt-2">This user has not created any posts yet.</p>
            @else
                <ul class="mt-4">
                    @foreach($posts as $post)
                        <li class="border-b border-gray-300 py-2">
                            <a href="{{ route('posts.show', ['id' => $post->id]) }}" class="block hover:bg-gray-100">
                                <h3 class="text-lg font-semibold">{{ $post->post_name }}</h3>
                                <p class="text-gray-600">{{ Str::limit($post->post_content, 100) }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>
</div>
