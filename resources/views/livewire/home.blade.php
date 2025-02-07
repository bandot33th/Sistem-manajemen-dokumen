<div>
    @if(session()->has('success'))
    <x-partials.toast :timeout="2000" icon="success" type="success" message="{{ session('success') }}" />
    @elseif(session()->has('error'))
    <x-partials.toast :timeout="2000" icon="error" message="{{ session('error') }}" type="error" />
    @endif

    {{-- ngecek permissionnya masuk apa engga --}}
    {{-- @haspermission('Workshop')
    <div>Hello world</div>
    @endhaspermission --}}

    {{-- @foreach($folders as $item)
    @if(auth()->user()->can($item->permission_name))
        ihsan
        <div class="flex">
            <a href="">{{$item->name}}</a>
        </div>
    @else
        bukan ihsan
        <div class="flex">
            <a href="">{{$item->name}}</a>
        </div>
    @endif
    @endforeach --}}


    <x-partials.breadcrumb :breadcrumbs="$breadcrumbs" />

    <div class="relative overflow-hidden overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex flex-wrap items-center justify-between p-3 space-y-4 flex-column sm:flex-row sm:space-y-0">
            <div class="inline-flex gap-2">
                @role('Admin')

                <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                    class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 dark:bg-gray-800 dark:text-white"
                    type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4 me-2">
                        <path fill-rule="evenodd"
                            d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"
                            clip-rule="evenodd" />
                    </svg>

                    <span>New</span>
                </button>
                <!-- Dropdown menu -->
                <div id="dropdown"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li class="cursor-pointer">
                            <a wire:click="createFolder"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                <div class="relative flex flex-wrap">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="size-4 me-2">
                                        <path fill-rule="evenodd"
                                            d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V10.5Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <span>Folder</span>
                                </div>
                            </a>
                        </li>
                        <li class="cursor-pointer">
                            <a data-modal-target="default-modal" data-modal-toggle="default-modal"
                                class="flex w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                                type="button">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                    class="size-4 me-2">
                                    <path fill-rule="evenodd"
                                        d="M5.625 1.5H9a3.75 3.75 0 0 1 3.75 3.75v1.875c0 1.036.84 1.875 1.875 1.875H16.5a3.75 3.75 0 0 1 3.75 3.75v7.875c0 1.035-.84 1.875-1.875 1.875H5.625a1.875 1.875 0 0 1-1.875-1.875V3.375c0-1.036.84-1.875 1.875-1.875ZM12.75 12a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25V18a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V12Z"
                                        clip-rule="evenodd" />
                                    <path
                                        d="M14.25 5.25a5.23 5.23 0 0 0-1.279-3.434 9.768 9.768 0 0 1 6.963 6.963A5.23 5.23 0 0 0 16.5 7.5h-1.875a.375.375 0 0 1-.375-.375V5.25Z" />
                                </svg>

                                <span>File</span>
                            </a>
                        </li>
                    </ul>
                </div>
                {{-- Upload modal --}}
                <div id="default-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative w-full max-w-2xl max-h-full p-4">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Upload Files
                                </h3>
                                <button type="button" wire:click="finish"
                                    class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg resetButton hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="default-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="p-2 overflow-x-hidden overflow-y-auto text-center max-h-96 scrollbar"
                                id="upload-container" data-folder-id="{{ $folderId }}"
                                data-breadcrumbs="{{ json_encode($breadcrumbs) }}">
                                <form action="{{ route('upload.docs') }}" method="POST" enctype="multipart/form-data"
                                    class="bg-gray-100 border-gray-300 dropzone" id="myDragAndDropUploader" wire:ignore>
                                    @csrf
                                </form>
                            </div>

                            <!-- Modal footer -->
                            <div id="finish-button"
                                class="flex items-center p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600">
                                <button data-modal-hide="default-modal" type="button" wire:click="finish"
                                    class="resetButton text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                    Finish</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endrole

                @if($this->hasSelectedItems)
                @if(count($this->selectedItems) > 1)
                <x-home.button type="edit" action="renameSelectedFolder" label="Edit"
                    iconPath="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                @elseif(count($this->selectedItems) == 1)
                <x-home.button type="edit" action="renameSelectedFolder" label="Edit"
                    iconPath="m14.304 4.844 2.852 2.852M7 7H4a1 1 0 0 0-1 1v10a1 1 0 0 0 1 1h11a1 1 0 0 0 1-1v-4.5m2.409-9.91a2.017 2.017 0 0 1 0 2.853l-6.844 6.844L8 14l.713-3.565 6.844-6.844a2.015 2.015 0 0 1 2.852 0Z" />
                @endif
                <x-home.button type="delete" action="$set('isModalOpen', true)" label="Delete"
                    iconPath="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                @elseif($this->hasSelectedFiles)
                <x-home.button type="delete" action="$set('isModalOpen', true)" label="Delete"
                    iconPath="M5 7h14m-9 3v8m4-8v8M10 3h4a1 1 0 0 1 1 1v3H9V4a1 1 0 0 1 1-1ZM6 7h12v13a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1V7Z" />
                <x-home.button type="download" action="downloadModal({{ $this->hasSelectedFiles }})" label="Download"
                    iconPath="M12 13V4M7 14H5a1 1 0 0 0-1 1v4a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-4a1 1 0 0 0-1-1h-2m-1-5-4 5-4-5m9 8h.01" />
                @endif
            </div>

            <x-home.searching :search="$search" :searching="$searching" />
        </div>

        {{-- table --}}
        <div class="overflow-y-auto">
            <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                <thead
                    class="sticky top-0 text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    @if($this->hasSelectedItems && $this->hasSelectedFiles)
                    <tr>
                        <div class="flex justify-between p-3 text-sm border-y bg-gray-50">
                            <span>{{ count($this->selectedItems) }} Folders & {{ count($this->selectedFiles) }} Files
                                Has Selected</span>
                        </div>
                    </tr>
                    @elseif ($this->hasSelectedItems)
                    <tr>
                        <div class="flex justify-between p-3 text-sm border-y bg-gray-50">
                            <span>{{ count($this->selectedItems) }} {{ (count($this->selectedItems) > 1) ? ' Folders
                                selected'
                                : ' Folder selected' }}</span>
                        </div>
                    </tr>
                    @elseif($this->hasSelectedFiles)
                    <tr>
                        <div class="flex justify-between p-3 text-sm border-y bg-gray-50">
                            <span>{{ count($this->selectedFiles) }} {{ (count($this->selectedFiles) > 1) ? ' Files
                                selected'
                                : ' file selected' }}</span>
                        </div>
                    </tr>
                    @endif
                    <tr>
                        @role('Admin')
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox" wire:model="selectAll"
                                    wire:click="selectAllItem"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded cursor-pointer focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        @endrole
                        <x-partials.table-header title="Folders" fieldName="name" :sortBy="$sortBy"
                            :sortDir="$sortDir" />
                        @if($documents->isNotEmpty())
                        <th scope="col" class="px-3 py-3">
                            <div class="inline-flex items-center justify-end w-full space-x-2">
                                <x-partials.show-item />
                            </div>
                        </th>
                        @endif
                    </tr>
                </thead>
                <tbody class="overscroll-contain">
                    @if($folders->isEmpty() && $documents->isEmpty())
                    <tr>
                        <td colspan="2" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                            This folder is empty.
                        </td>
                    </tr>
                    @endif
                    @php
                    $userPermissionsArray = $this->parentPermissions;
                    @endphp

                    @role('Admin')
                    @foreach ($folders as $folder)
                    <tr colspan="2"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 hover:w-full dark:hover:bg-gray-600"
                        :class="{ 'border-l-4 border-blue-500 border-b-gray-200': @json(in_array($folder->id, $selectedItems)) }">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" wire:model="selectedItems"
                                    value="{{ $folder->id }}" wire:click="checkIfAllSelected"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded cursor-pointer focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th colspan="2" scope="row"
                            class="px-6 py-4 font-medium text-gray-900 cursor-pointer whitespace-nowrap dark:text-white"
                            :class="{ '': @json(in_array($folder->id, $selectedItems)) }"
                            @click="window.location.href = '{{ route('home', $folder->id) }}'">

                            <!-- create folder -->
                            <a href="{{ route('home', $folder->id) }}">
                                @if($isCreatingNewFolder && $folder->name === 'New Folder')
                                <input x-data x-ref="folderInput" x-init="$nextTick(() => $refs.folderInput.focus())"
                                    x-on:keydown.enter="$wire.saveFolderName({{ $folder->id }})" type="text"
                                    wire:model.defer="newFolderName" wire:blur="saveFolderName({{ $folder->id }})"
                                    class="form-control me-2 rounded {{ empty($newFolderName) ? 'is-invalid' : '' }}"
                                    style="width: auto;" autofocus required />
                                @if(empty($newFolderName))
                                <div class="text-xs text-red-500">The folder name can't be empty!</div>
                                @endif

                                {{-- rename folder --}}
                                @elseif($isRenamingFolder && $folderBeingRenamed == $folder->id)
                                <input x-data x-ref="folderInput" x-init="$nextTick(() => $refs.folderInput.focus())"
                                    x-on:keydown.enter="$wire.saveFolderName({{ $folder->id }})" type="text"
                                    wire:model.defer="newFolderName" wire:blur="saveFolderName({{ $folder->id }})"
                                    class="form-control me-2 rounded {{ empty($newFolderName) ? 'is-invalid' : '' }}"
                                    style="width: auto;" autofocus />
                                @if(empty($newFolderName))
                                <div class="form-text text-danger">The folder name can't be empty!</div>
                                @endif
                                @else
                                <div class="flex gap-2">
                                    <svg class="w-5 h-5 text-amber-300" viewBox="0 0 24 24" fill="currentColor"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                                    </svg>
                                    {{ $folder->name }}
                                </div>
                            </a>
                            @endif
                        </th>
                    </tr>
                    @endforeach

                    @if($documents && $documents->isNotEmpty())
                    @foreach ($documents as $items)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        :class="{ 'border-l-4 border-blue-500 border-b-gray-200': @json(in_array($items->id, $selectedFiles)) }">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" wire:model="selectedFiles"
                                    value="{{ $items->id }}" wire:click="checkIfAllSelected"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded cursor-pointer focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        @php
                        $explode = explode('/', $items->path);
                        $filename = end($explode);
                        $url = route('document.view', $filename);
                        $isSelected = in_array($items->id, $selectedFiles); // Check if item is selected
                        @endphp
                        <th colspan="2" scope="row"
                            class="px-6 py-4 font-medium text-gray-900 cursor-pointer whitespace-nowrap dark:text-white"
                            :class="{ '': @json(in_array($items->id, $selectedFiles)) }"
                            @click="window.open('{{ $url }}', '_blank')">
                            <a href="{{ route('document.view', $filename) }}" target="_blank" class="cursor-pointer">
                                <div class="flex gap-2">
                                    <svg class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="16" y1="13" x2="8" y2="13" />
                                        <line x1="16" y1="17" x2="8" y2="17" />
                                        <polyline points="10 9 9 9 8 9" />
                                    </svg>
                                    {{ $items->doc_name }}
                                </div>
                            </a>
                        </th>
                    </tr>
                    @endforeach
                    @endif
                    @else
                    @foreach ($folders as $folder)
                    @if(auth()->user()->can($folder->permission_name))
                    <tr
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('home', $folder->id) }}">
                                <div class="flex gap-2">
                                    <svg class="w-5 h-5 text-amber-300" viewBox="0 0 24 24" fill="currentColor"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z" />
                                    </svg>
                                    {{ $folder->name }}
                                </div>
                            </a>
                        </th>
                    </tr>
                    @endif
                    @endforeach
                    @if($documents && $documents->isNotEmpty())
                    @foreach ($documents as $items)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600"
                        :class="{ 'border-l-4 border-blue-500 border-b-gray-200': @json(in_array($items->id, $selectedFiles)) }">
                        @role('Admin')
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox" wire:model="selectedFiles"
                                    value="{{ $items->id }}" wire:click="checkIfAllSelected"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        @endrole
                        @php
                        $explode = explode('/', $items->path);
                        $filename = end($explode);
                        @endphp
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('document.view', $filename) }}" target="_blank" class="cursor-pointer">
                                <div class="flex gap-2">
                                    <svg class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                                        <polyline points="14 2 14 8 20 8" />
                                        <line x1="16" y1="13" x2="8" y2="13" />
                                        <line x1="16" y1="17" x2="8" y2="17" />
                                        <polyline points="10 9 9 9 8 9" />
                                    </svg>
                                    {{ $items->doc_name }}
                                </div>
                            </a>
                        </th>
                    </tr>
                    @endforeach
                    @endif
                    @endrole


                </tbody>
            </table>
        </div>
        {{-- end table --}}
        <div class="p-4" id="pagination-container">
            {{ $documents->links() }}
        </div>
        @if ($isDownload)
        <x-partials.download-modal />
        @endif

        @if ($isModalOpen)
        <x-partials.delete-modal title="Delete selected items" action="deleteSelectedItems" params="isModalOpen" />
        @endif

        {{-- @if($isModalFileUpload) --}}
        {{--
        <x-partials.upload-modal /> --}}
        {{-- @endif --}}
    </div>
</div>

@push('scripts')
@vite(['resources/js/external/upload-home.js'])
@endpush
