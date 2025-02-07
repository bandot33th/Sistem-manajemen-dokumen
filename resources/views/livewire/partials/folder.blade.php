<div class="ml-4">
    <div class="flex items-center">
        <input type="checkbox" wire:model="selectedFolders" value="{{ $folder->id }}"
            class="w-4 h-4 mr-2 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 focus:ring-2">

        @if($folder->parent_id == null)
        <span class="font-semibold text-gray-700 cursor-pointer" onclick="toggleBranch('branch-{{ $folder->id }}')">{{
            $folder->name }}</span>
        @else
        <span class="text-gray-700 cursor-pointer" onclick="toggleBranch('branch-{{ $folder->id }}')">{{ $folder->name
            }}</span>
        @endif
    </div>

    @if($folder->children->isNotEmpty())
    <div id="branch-{{ $folder->id }}" class="hidden mt-2 ml-6">
        @foreach($folder->children as $childFolder)
        @include('livewire.partials.folder', ['folder' => $childFolder])
        @endforeach
    </div>
    @endif
</div>
