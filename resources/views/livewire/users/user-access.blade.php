<div class="flex items-center">
    <input type="checkbox" wire:model="selectedFolders" value="{{ $folder->id }}"
        class="w-4 h-4 mr-2 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">
    <svg class="w-5 h-5 text-amber-300 me-2" viewBox="0 0 24 24" fill="currentColor"
        stroke="currentColor" stroke-width="2" stroke-linecap="round"
        stroke-linejoin="round">
        <path
            d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
    </svg>
    <span onclick="toggleBranch('branch-{{ $folder->id }}')" class="text-gray-700 cursor-pointer">
        {{ $folder->name }}
    </span>
</div>

@if($folder->children->isNotEmpty())
<div id="branch-{{ $folder->id }}" class="hidden ml-6">
    @foreach($folder->children as $childFolder)
    @include('livewire.users.user-access', ['folder' => $childFolder])
    @endforeach
</div>
@endif
