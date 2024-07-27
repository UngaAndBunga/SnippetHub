@props(['votes_percent'])
<div>
    <div class="flex items-center">
        <span class="mr-2">{{ number_format($votes_percent, 2) }}%</span>
        <button wire:click="vote('positive')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-2 rounded">
            +
        </button>
        <button wire:click="vote('negative')" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded ml-2">
            -
        </button>
    </div>
</div>
