<div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-4">
    <div class="p-6 text-gray-900 dark:text-gray-100">
        <h2 class="text-xl font-semibold">Followed Users</h2>
        @if($followedUsers->isEmpty())
            <p class="mt-2">You are not following any users yet.</p>
        @else
            <ul class="mt-4">
                @foreach($followedUsers as $user)
                    <li class="border-b border-gray-300 py-2">
                        <a href="{{ route('users.show', ['id' => $user->id]) }}" class="block hover:bg-gray-100">
                            <h3 class="text-lg font-semibold">{{ $user->name }}</h3>
                            <p class="text-gray-600">{{ $user->email }}</p>
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
