@php
$fieldName = $fieldName ?? null;
$sortBy = $sortBy ?? null;
$sortDir = $sortDir ?? null;
@endphp

<th scope="col" class="px-3 py-3" @if($fieldName) wire:click="setSortBy('{{ $fieldName }}')" @endif>
    <div class="inline-flex items-center cursor-pointer">
        {{ $title }}
        @if ($fieldName && $sortBy === $fieldName)
        @if ($sortDir === 'ASC')
        <svg class="w-4 h-4 ml-1 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6v13m0-13 4 4m-4-4-4 4" />
        </svg>
        @else
        <svg class="w-4 h-4 ml-1 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 19V5m0 14-4-4m4 4 4-4" />
        </svg>
        @endif
        @elseif ($fieldName && $sortBy !== $fieldName)
        <svg class="w-4 h-4 ml-2 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
            width="24" height="24" fill="none" viewBox="0 0 24 24">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M8 20V10m0 10-3-3m3 3 3-3m5-13v10m0-10 3 3m-3-3-3 3" />
        </svg>
        @endif
    </div>
</th>