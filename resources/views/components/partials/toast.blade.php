@props(['icon', 'type', 'message' ,'timeout'])
@php
$icon = match($icon) {
'success' => 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1
1.414-1.414L9
10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z',
'error' => 'M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293
2.293a1 1 0 0
1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293
2.293Z'
};

$type = match ($type) {
'success'=> "inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg
dark:bg-green-800
dark:text-green-200",
'error' => "inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-red-500 bg-red-100 rounded-lg
dark:bg-red-800 dark:text-red-200",
}

@endphp

<div id="toast-top-right" class="fixed z-10 flex items-center w-full max-w-xs mt-12 top-5 right-5" role="alert"
    x-data="{ show: true, timeout: null }" x-init="timeout = setTimeout(() => show = false, {{ $timeout ?? 5000 }})"
    x-show="show" x-transition:enter="transition transform ease-out duration-700"
    x-transition:enter-start="translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition transform ease-in duration-700" x-transition:leave-start="translate-x-0 opacity-100"
    x-transition:leave-end="translate-x-full opacity-0" class="absolute top-0 right-0 z-50 p-4">
    <div id="toast-success"
        class="flex items-center w-full max-w-xs p-4 mb-4 text-gray-500 bg-white rounded-lg shadow dark:text-gray-400 dark:bg-gray-800"
        role="alert">
        <div class="{{ $type }}">
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                viewBox="0 0 20 20">
                <path d="{{ $icon }}" />
            </svg>
            <span class="sr-only">Check icon</span>
        </div>
        <div class="text-sm font-normal ms-3">{{ $message }}</div>  
    </div>
</div>
