<div>

    @if(session()->has('success'))
    <x-partials.toast :timeout="2000" icon="success" type="success" message="{{ session('success') }}" />
    @elseif(session()->has('error'))
    <x-partials.toast :timeout="2000" icon="error" message="{{ session('error') }}" type="error" />
    @endif

    <div class="p-3 mb-4 border rounded-lg shadow-md">
        <div class="sm:hidden">
            <label for="Tab" class="sr-only">Tab</label>
            <select id="Tab" class="w-full border-gray-200 rounded-md" wire:model.live="query">
                <option value="1">Show All</option>
                <option value="2">Mechanical</option>
                <option value="3">Electrical</option>
                <option value="4">Civil</option>
                <option value="5">Utility</option>
            </select>
        </div>

        <div class="hidden sm:block shrink-0">
            <nav class="flex flex-wrap items-center justify-between" aria-label="Tabs">
                <div class="relative inline-block">
                    <button id="dropdownDefaultButton"
                        wire:click="$set('isDropdown', {{ $isDropdown ? 'false' : 'true' }})"
                        class="inline-flex items-center p-2 text-sm font-medium text-gray-500 rounded-lg tab-button shrink-0 ms-right"
                        type="button">
                        {{ $title }}
                        <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 1l4 4 4-4" />
                        </svg>
                    </button>

                    @if($isDropdown)
                    <div
                        class="absolute left-0 z-50 w-32 py-1 mt-2 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700">
                        <ul class="space-y-2">
                            @foreach(['Show All', 'Mechanical', 'Electrical', 'Civil', 'Utility'] as $key => $label)
                            <li>
                                <button
                                    class="w-full h-full text-left shrink-0 p-2 text-sm font-medium
                                            {{ $query == $key ? 'bg-sky-100 text-sky-600' : 'text-gray-500 hover:bg-gray-50 hover:text-gray-700' }}"
                                    wire:click="queryTab({{ $key }})">
                                    {{ $label }}
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>


                <div>
                    {{-- add masterlist button --}}
                    <button
                        class="p-2 text-sm font-medium text-gray-500 rounded-lg addmasterlist-slide-trigger tab-button shrink-0 ms-right me-5">
                        AddMasterlist
                    </button>

                    {{-- import=export button --}}
                    <button id="multiLevelDropdownButton" data-dropdown-toggle="multi-dropdown"
                        class="inline-flex items-center p-2 text-sm font-medium text-gray-500 rounded-lg tab-button shrink-0 ms-right"
                        type="button">Import & Export <svg class="w-2.5 h-2.5 ms-3" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 4 4 4-4" />
                        </svg>
                    </button>

                    <!-- Dropdown menu -->
                    <div id="multi-dropdown"
                        class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                        <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                            aria-labelledby="multiLevelDropdownButton">
                            <li>
                                <a data-modal-target="default-modal" data-modal-toggle="default-modal"
                                    class="block px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:cursor-pointer">
                                    Import
                                </a>
                            </li>
                            <li>
                                <button id="doubleDropdownButton" data-dropdown-toggle="doubleDropdown"
                                    data-dropdown-placement="right-start" type="button"
                                    class="flex items-center justify-between w-full px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Export<svg
                                        class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 9 4-4-4-4" />
                                    </svg></button>
                                <div id="doubleDropdown"
                                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700">
                                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200"
                                        aria-labelledby="doubleDropdownButton">
                                        <li>
                                            <a wire:click="export('Mechanical')"
                                                class="block px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:cursor-pointer">
                                                Mechanical
                                            </a>
                                        </li>
                                        <li>
                                            <a wire:click="export('Electrical')"
                                                class="block px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:cursor-pointer">
                                                Electrical
                                            </a>
                                        </li>
                                        <li>
                                            <a wire:click="export('Civil')"
                                                class="block px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:cursor-pointer">
                                                Civil
                                            </a>
                                        </li>
                                        <li>
                                            <a wire:click="export('Utility')"
                                                class="block px-4 py-2 text-left hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white hover:cursor-pointer">
                                                Utility
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="relative overflow-y-auto bg-white sm:rounded-lg">
        <section class="relative flex overflow-hidden">
            <div class="relative w-full transition-transform duration-500 ease-in-out table-container ">
                <div class="overflow-x-auto border border-gray-200 rounded-lg ">
                    <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <x-partials.table-header title="Drawing Number" />
                                <x-partials.table-header title="Category" fieldName="category_master_list_id"
                                    :sortBy="$sortBy" :sortDir="$sortDir" />
                                <x-partials.table-header title="Address of Drawing" fieldName="address_of_drawing"
                                    :sortBy="$sortBy" :sortDir="$sortDir" />
                                <x-partials.table-header title="Name Machine" fieldName="name_of_machine"
                                    :sortBy="$sortBy" :sortDir="$sortDir" />
                                <x-partials.table-header title="Masterlist Sheet" fieldName="slug" :sortBy="$sortBy"
                                    :sortDir="$sortDir" />
                                <x-partials.table-header title="Actions" />
                            </tr>
                        </thead>
                        <tbody>
                            @if($masterlist->isEmpty())
                            <tr class="hover:bg-gray-50">
                                <td colspan="6" class="w-full px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                                    This Masterlist is Empty.
                                </td>
                            </tr>
                            @endif
                            @foreach ($masterlist as $item)
                            <tr class="border-b hover:bg-gray-50">
                                <th scope="row" style="width: 10%"
                                    class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $item->drawing_number }}
                                </th>
                                <th scope="row"
                                    class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->category->name }}
                                </th>
                                <th scope="row"
                                    class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->address_of_drawing }}
                                </th>
                                <th scope="row"
                                    class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->name_of_machine }}
                                </th>
                                <th scope="row"
                                    class="px-3 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{$item->slug }}
                                </th>
                                <td class="px-3 py-3">
                                    <button type="button" wire:click="viewDetails({{ $item->id }})"
                                        class="p-2 font-medium text-orange-600 dark:text-indigo-500 hover:text-orange-400">
                                        View
                                    </button>

                                    <button type="button" wire:click="selectForEdit({{ $item->id }})"
                                        class="p-2 font-medium text-blue-600 dark:text-blue-500 hover:text-blue-400 ">
                                        Update
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <section id="update-form"
                class="relative w-full max-h-screen p-4 pt-0 overflow-y-auto form-container scrollbar lg:max-h-[75vh] hidden">
                <div class="flex items-center justify-between mb-4">
                    <button id="back-button"
                        class="flex items-center text-black hover:bg-gray-100 font-medium rounded-lg text-sm px-3 py-1.5">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                            class="size-4 me-2">
                            <path fill-rule="evenodd"
                                d="M7.72 12.53a.75.75 0 0 1 0-1.06l7.5-7.5a.75.75 0 1 1 1.06 1.06L9.31 12l6.97 6.97a.75.75 0 1 1-1.06 1.06l-7.5-7.5Z"
                                clip-rule="evenodd" />
                        </svg>
                        Back
                    </button>
                    <h3 class="font-semibold text-center">Add Masterlist</h3>
                </div>
                <form class="max-w-sm mx-auto" wire:submit="save">
                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Masterlist Category
                        </label>
                        <select name="HeadlineAct" id="HeadlineAct" wire:model="category"
                            class="mt-1.5 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm">
                            <option value="">Please select</option>
                            @foreach ($category_list as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                            Address of Drawing
                        </label>
                        <input type="text" id="email" wire:model="address"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="P1" required />
                    </div>
                    <div class="mb-5">
                        <label for="HeadlineAct" class="block text-sm font-medium text-gray-900">
                            Name of Machine
                        </label>
                        <input type="text" id="machineName" wire:model="machineName"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="BANBURY 1" required />
                    </div>
                    <div class="mb-5">
                        <label for="OrderNotes" class="block text-sm font-medium text-gray-700">
                            Drawing File Contents
                        </label>
                        <textarea id="OrderNotes" wire:model="fileContent"
                            class="w-full mt-2 align-top border-gray-200 rounded-lg shadow-sm sm:text-sm max-h-64"
                            rows="4" placeholder="Enter drawing file contents"></textarea>
                    </div>
                    <div class="mb-5">
                        <label for="OrderNotes" class="block text-sm font-medium text-gray-700">
                            Remarks
                        </label>
                        <textarea id="OrderNotes" wire:model="remarks"
                            class="w-full mt-2 align-top border-gray-200 rounded-lg shadow-sm sm:text-sm max-h-64"
                            rows="4" placeholder="Enter Remarks"></textarea>
                    </div>
                    <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Submit
                    </button>
                </form>
            </section>
        </section>

        <div class="p-4">
            {{ $masterlist->links() }}
        </div>
    </div>

    {{-- dropdown content --}}

    {{-- import modal --}}
    <!-- Modal toggle -->

    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Import Masterlist
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg resetButton hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-2 overflow-x-hidden overflow-y-auto text-center max-h-96 scrollbar">
                    <form action="{{ url('upload-masterlist') }}" method="POST" enctype="multipart/form-data"
                        class="bg-gray-100 border-gray-300 dropzone" id="myDragAndDropUploader" wire:ignore>
                        @csrf
                    </form>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 border-t border-gray-200 rounded-b md:p-5 dark:border-gray-600"
                    id="finish-button">
                    <button data-modal-hide="default-modal" type="button" wire:click="finish"
                        class="resetButton text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        Finish</button>
                </div>
            </div>
        </div>
    </div>


    {{-- edit modal --}}
    @if ($isEdit)
    <div tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 flex items-center justify-center w-full bg-black bg-opacity-50">
        <div class="relative w-full max-w-md max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-2 border-b rounded-t md:p-3 dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Update MasterList
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        wire:click="close">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 overflow-auto md:p-4 max-h-96 scrollbar" wire:submit="edit">
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div class="col-span-2">
                            <label for="name"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address Of
                                Drawing</label>
                            <input wire:model="address" type="text" name="name" id="name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Type product name" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="machine"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name of
                                Machine</label>
                            <input wire:model="machineName" type="text" name="machine" id="machine"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                placeholder="Type product name" required="">
                        </div>
                        <div class="col-span-2">
                            <label for="category" class="block text-sm font-medium text-gray-900 dark:text-white">
                                Masterlist Category
                            </label>
                            <select name="category" id="HeadlineAct" wire:model="category"
                                class="mt-1.5 w-full rounded-lg border-gray-300 text-gray-700 sm:text-sm">
                                <option value="">Please select</option>
                                @foreach ($category_list as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-span-2">
                            <label for="content"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Drawing File
                                Content</label>
                            <textarea wire:model="fileContent" id="content" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Write product description here"></textarea>
                        </div>
                        <div class="col-span-2">
                            <label for="remarks"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remarks</label>
                            <textarea wire:model="remarks" id="remarks" rows="4"
                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Write product description here"></textarea>
                        </div>
                    </div>
                    <div
                        class="sticky flex items-center p-3 border-t border-gray-200 rounded-b md:p-3 dark:border-gray-600">
                        <button type="submit"
                            class="inline-flex items-center px-5 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Update Masterlist
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    {{-- view detail modal --}}

    @if ($isView)
    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 top-0 left-0 right-0 z-50 flex items-center justify-center w-full max-h-full overflow-x-hidden overflow-y-auto bg-black bg-opacity-50">
        <div class="relative w-full max-w-2xl max-h-full p-3">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Masterlist Detail
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        wire:click="close">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 space-y-4 md:p-5">
                    <div class="">
                        <table class="min-w-full text-sm bg-white divide-y-2 divide-gray-200">
                            <tbody class="divide-y divide-gray-200">
                                {{-- @dd($details->address_of_drawing) --}}
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Drawing Number
                                    </td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $details->drawing_number }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Category</td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $details->category->name }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Address of Drawing
                                    </td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{
                                        $details->address_of_drawing }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Machine Name</td>
                                    <td class="px-4 py-2 whitespace-nowrap texat-gray-700">{{ $details->name_of_machine
                                        }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Masterlist Sheet
                                    </td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $details->slug }}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Drawing File
                                        Contents</td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{!!
                                        nl2br(e($details->drawing_file_contents )) !!}</td>
                                </tr>
                                <tr>
                                    <td class="px-4 py-2 font-medium text-gray-900 whitespace-nowrap">Remarks</td>
                                    <td class="px-4 py-2 text-gray-700 whitespace-nowrap">{{ $details->remarks }}</td>
                                </tr>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>



@push('scripts')
@vite(['resources/js/external/masterlist.js'])
@endpush
