<div class="inline-flex gap-2">
    <label for="table-search" class="sr-only">Search</label>
    <div class="relative">
        <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none rtl:inset-r-0 rtl:right-0 ps-3">
            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor"
                viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd"
                    d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                    clip-rule="evenodd"></path>
            </svg>
        </div>

        <input type="search" id="dropdown-button" wire:model.live="search"
            class="block p-2 text-sm text-gray-900 bg-transparent border border-gray-300 rounded-lg ps-10 w-80 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            placeholder="Search for items" autocomplete="off">
        @if(!empty($searching) && count($searching) > 0)
        <div id="dropdown"
            class="absolute z-10 mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow w-80 dark:bg-gray-700 max-h-60 overflow-y-auto searching-scrollbar">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                @foreach($searching as $item)
                <li>
                    <a href="{{ route('home', $item->folder_id) }}"
                        class="flex flex-col w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                        <p class="text-base truncate">{{ $item->doc_name }}</p>
                        <span class="text-xs truncate">{{ collect(explode('/', $item->path))->slice(1,
                            -1)->implode('/') }}</span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>

        @elseif(strlen($search) > 0)
        <div id="dropdown"
            class="absolute z-10 mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow w-80 dark:bg-gray-700">
            <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-button">
                <li>
                    <span class="block px-4 py-2">No results for: {{ $search }}</span>
                </li>
            </ul>
        </div>
        @endif
    </div>
</div>
