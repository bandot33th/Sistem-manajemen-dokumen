<div>
    @if(session()->has('success'))
    <x-partials.toast :timeout="2000" icon="success" type="success" message="{{ session('success') }}" />
    @elseif(session()->has('error'))
    <x-partials.toast :timeout="2000" icon="error" message="{{ session('error') }}" type="error" />
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <div class="flex flex-wrap items-center justify-between pb-3 space-y-4 flex-column sm:flex-row sm:space-y-0">
            {{-- Search Bar --}}
            <div class="p-3 pb-1 bg-white dark:bg-gray-900">
                <x-partials.search />
            </div>

            <div class="inline-flex items-center p-3 pb-1">
                <div class="flex">
                    <x-partials.show-item />
                </div>
            </div>
        </div>
        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <x-partials.table-header title="Name" fieldName="name" :sortBy="$sortBy" :sortDir="$sortDir" />
                    {{-- <x-partials.table-header title="User Access" /> --}}
                    <x-partials.table-header title=" Department " fieldName="department" :sortBy="$sortBy"
                        :sortDir="$sortDir" />
                    <x-partials.table-header title="Role " />
                    @role('Admin')
                    <x-partials.table-header title="Email " fieldName="email" :sortBy="$sortBy" :sortDir="$sortDir" />
                    @endrole
                    @role('Admin')
                    <x-partials.table-header title="Action" />
                    @endrole
                </tr>
            </thead>

            <tbody class="bg-white divide-y divide-gray-200 ">
                @foreach ($users as $user)
                <tr class="hover:bg-gray-50">
                    <td class="px-3 py-4 whitespace-nowrap ">
                        <div class="text-sm font-medium text-gray-900">
                            {{ $user->name }}
                        </div>
                    </td> 
                    <td class="px-3 py-4 whitespace-nowrap">
                        <div class="text-sm text-gray-900">{{ $user->department }}</div>
                    </td>
                    <td class="px-3 py-4 text-php sm text-gray-500 whitespace-nowrap">
                        @foreach ($user->roles as $role)
                            {{ $role->name }}{{ !$loop->last ? ', ' : '' }}
                        @endforeach
                    </td>
                    
                    @role('Admin')
                    <td class="px-3 py-4 text-sm text-gray-500 whitespace-nowrap">
                        {{ $user->email }}
                    </td>
                    @endrole
                    @role('Admin')
                    <td class="px-3 py-4 text-sm font-medium whitespace-nowrap">
                        <a wire:click="selectForEdit({{ $user->id }})"
                            class="text-indigo-600 cursor-pointer hover:text-indigo-700">Edit</a>
                        <a wire:click="selectedItem({{ $user->id }})"
                            class="ml-2 text-red-600 cursor-pointer hover:text-red-700">Delete</a>
                    </td>
                    @endrole
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Table End --}}

        <div class="p-4 mt-5">
            {{ $users->links() }}
        </div>

        @if ($isModalOpen)
        <x-partials.delete-modal title="Delete selected user" action="delete" params="isModalOpen" />
        @endif

        {{-- edit modal --}}
        @if ($isEdit)
        <div id="edit-modal" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 flex items-center justify-center w-full bg-black bg-opacity-50">
            <div class="relative w-full max-w-md max-h-full p-4">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            User Personal Data
                        </h3>
                        <button type="button"
                            class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                            wire:click="$set('isEdit', false)">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5">
                        <form class="space-y-4" wire:submit.prevent="submitAccess">
                            <div>
                                <label for="name"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name</label>
                                <input type="text" name="name" id="name"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    wire:model="name" placeholder="Insert Your Name" required autocomplete="none">
                            </div>
                            <div>
                                <label for="email"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                <input type="text" name="email" id="email"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    wire:model="email" placeholder="Insert Your Email" required autocomplete="none">
                            </div>
                            <div>
                                <label for="password"
                                    class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                                <input type="password" name="password" id="password"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                    wire:model="password" autocomplete="none" placeholder="Enter new password">
                            </div>

                            <div>
                                <label for="role" class="flex flex-wrap mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                                <div class="flex flex-wrap gap-3">
                                    @foreach ($roles as $role)
                                        <div class="flex items-center">
                                            <input 
                                                type="checkbox" 
                                                id="role-{{ $role->id }}" 
                                                value="{{ $role->id }}" 
                                                wire:model.lazy="selectedRoles" 
                                                class="w-4 h-4 text-primary-500 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600">
                                            <label 
                                                for="role-{{ $role->id }}" 
                                                class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                                {{ $role->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>                            

                            <button type="submit" 
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-80">
                                Confirm
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
        {{-- @if($userAccess)
        <div id="user-access-modal" tabindex="-1" aria-hidden="true"
            class="fixed inset-0 z-50 flex items-center justify-center w-full bg-black bg-opacity-50">
            <div class="relative w-full max-w-4xl max-h-full p-5">
                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                    <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                        <div class="flex items-center gap-2">
                            <button type="button" wire:click="goBackToEditModal"
                                class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                                </svg>
                                <span class="sr-only">Back</span>
                            </button>

                            <!-- Modal Title -->
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                User Access
                            </h3>
                        </div>

                        <!-- Close Button -->
                        <button type="button" wire:click="closeModal"
                            class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>

                    <!-- Modal body -->
                    <form wire:submit.prevent="submitAccess">
                        <div class="p-2 space-y-4">
                            <div class="p-4 overflow-y-auto max-h-96 scrollbar">
                                <div class="">
                                    @foreach($folders as $folder)
                                    <div class="relative flex items-center p-3 mb-2 border rounded-md">
                                        <div class="ml-2 hover:cursor-pointer">
                                            @include('livewire.users.user-access', ['folder' => $folder])
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <!-- Modal footer -->
                        <div class="flex items-center p-4 border-gray-200 rounded-b md:p-4 dark:border-gray-600">
                            <button type="submit"
                                class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Submit
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        @endif --}}
    </div>
</div>


@push('scripts')
    @vite(['resources/js/external/addUser.js'])
@endpush
