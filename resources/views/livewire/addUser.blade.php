<div>
    @if(session()->has('success'))
    <x-partials.toast :timeout="2000" icon="success" type="success" message="{{ session('success') }}" />
    @elseif(session()->has('error'))
    <x-partials.toast :timeout="2000" icon="error" message="{{ session('error') }}" type="error" />
    @endif

    <div id="accordion-open" data-accordion="collapse" class="shadow-md sm:rounded-lg">
        {{-- Personal Info --}}
        <form wire:submit="addUser">
            <h2 id="accordion-open-heading-1">
                <button type="button"
                    class="flex items-center justify-between w-full gap-3 p-5 font-medium text-gray-500 border border-gray-200 rtl:text-right rounded-t-md  dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800"
                    data-accordion-target="#accordion-open-body-1" aria-expanded="true"
                    aria-controls="accordion-open-body-1">
                    <span class="flex items-center"><svg class="w-5 h-5 text-gray-900 me-2" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg></svg>Personal Info</span>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5 5 1 1 5" />
                    </svg>
                </button>
            </h2>
            <div id="accordion-open-body-1" class=""
                aria-labelledby="accordion-open-heading-1">
                <div class="p-5 border border-gray-200 dark:border-gray-700 dark:bg-gray-900">
                    <div class="grid gap-4 sm:grid-cols-2">
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
                                wire:model="email" placeholder="Insert Your Email" required="">
                        </div>
                        <div>
                            <label for="department"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                            <select id="department" wire:model="department" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option disabled value="">Select Department</option>
                                <option value="Engineering">Engineering</option>
                            </select>
                        </div>
                        <div>
                            <label for="password"
                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                            <input type="password" name="password" id="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500"
                                wire:model="password" placeholder="Insert Your Password" required>
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
                                            class="w-4 h-4 text-primary-500 bg-gray-100 border-gray-300 rounded focus:ring-primary-500 dark:focus:ring-primary-600 dark:ring-offset-gray-800 dark:bg-gray-700 dark:border-gray-600"
                                            @if (in_array($adminRoleId, $selectedRoles) && $role->id !== $adminRoleId) disabled @endif>
                                        <label
                                            for="role-{{ $role->id }}"
                                            class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">
                                            {{ $role->name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </div>

            <div class="flex justify-center">
                <button type="submit"
                    class=" mt-7 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 shadow-xl">
                    Submit
                </button>
            </div>
        </form>
</div>

@push('scripts')

    @vite(['resources/js/external/addUser.js'])
@endpush
