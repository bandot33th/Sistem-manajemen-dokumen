<div>
    @if(session()->has('success'))
    <x-partials.toast :timeout="2000" icon="success" type="success" message="{{ session('success') }}" />
    @elseif(session()->has('error'))
    <x-partials.toast :timeout="2000" icon="error" message="{{ session('error') }}" type="error" />
    @endif


    <div id="accordion-nested-parent" data-accordion="open" class="shadow-md sm:rounded-lg">
        <h2 id="accordion-collapse-heading-1">
        <button type="button" class="flex items-center justify-between w-full gap-3 p-5 font-medium text-gray-500 border border-gray-200 rtl:text-right rounded-t-xl  dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-collapse-body-1" aria-expanded="true" aria-controls="accordion-collapse-body-1">
            <div class="flex items-center gap-3">
                <svg class="w-5 h-5 text-black" width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" />
                    <rect x="5" y="11" width="14" height="10" rx="2" />
                    <circle cx="12" cy="16" r="1" />
                    <path d="M8 11v-4a4 4 0 0 1 8 0v4" />
                </svg>
                <span>Document Password</span>
            </div>
            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
            </svg>
        </button>
        </h2>
        <div id="accordion-collapse-body-1" class="hidden" aria-labelledby="accordion-collapse-heading-1">
        <div class="p-5 border border-gray-200 rounded-b-xl dark:border-gray-700 dark:bg-gray-900">
            <div class="pb-5 pl-2 border-gray-200 dark:border-gray-700">
                <span class="font-semibold">Document Password :</span> {{ $passwordDoc->password }}
            </div>
            <!-- Nested accordion -->
            @role('Admin')
            <div id="accordion-nested-collapse" data-accordion="collapse" class="shadow-md">
                <h2 id="accordion-nested-collapse-heading-1">
                    <button type="button" class="flex items-center justify-between w-full gap-3 p-5 font-medium text-gray-500 border border-gray-200 rounded-t-xl rtl:text-right     dark:focus:ring-gray-800 dark:border-gray-700 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800" data-accordion-target="#accordion-nested-collapse-body-1" aria-expanded="false" aria-controls="accordion-nested-collapse-body-1">
                        <div class="flex items-center gap-3">
                            <svg class="w-5 h-5 text-black" width="24" height="24" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z" />
                            </svg>
                            <span>Edit Password</span>
                        </div>
                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                    </svg>
                    </button>
                </h2>
                <div id="accordion-nested-collapse-body-1" class="hidden" aria-labelledby="accordion-nested-collapse-heading-1">
                    <div class="p-5 border border-gray-200 dark:border-gray-700 rounded-b-md">
                        <div class="flex items-center justify-center">
                            <form class="items-center" wire:submit.prevent="save">
                                <div class="flex flex-col items-center px-2 bg-white border border-gray-200 rounded-lg shadow md:flex-row md:max-w-xl dark:border-gray-700 dark:bg-gray-800">
                                    <img class=" w-full rounded-t-lg sm:h-auto sm:w-40 p-4 px-7 md:rounded-none md:rounded-s-lg" src="/img/bs-logo.png" alt="">
                                    <div class="flex flex-col justify-between p-6 leading-normal">
                                        <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                            Password Documents
                                        </h5>
                                        <div class="relative">
                                            <input id="passwordInput" type="password" class="block w-full py-3 mb-2 text-sm bg-transparent border-b-2 peer pe-0 ps-8 border-t-transparent border-x-transparent border-b-gray-200 focus:border-t-transparent focus:border-x-transparent focus:border-b-blue-500 focus:ring-0 disabled:opacity-50 disabled:pointer-events-none dark:border-b-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 dark:focus:border-b-neutral-600" placeholder="Enter New Password" wire:model="password">

                                            <div class="absolute inset-y-0 flex items-center pointer-events-auto start-0 ps-2 peer-disabled:opacity-50 peer-disabled:pointer-events-none">
                                                <svg class="text-gray-500 shrink-0 size-5 dark:text-neutral-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"></path>
                                                    <circle cx="16.5" cy="7.5" r=".5"></circle>
                                                </svg>
                                            </div>

                                            <button type="button" class="password-toggle-button absolute inset-y-0 end-0 pe-2 text-gray-500 hover:text-gray-700 dark:text-neutral-500 dark:hover:text-neutral-400">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                                </svg>
                                            </button>
                                        </div>
                                        <button type="submit" class="inline-flex items-center px-4 py-3 text-sm font-medium text-blue-600 border border-transparent rounded-lg gap-x-2 hover:bg-blue-100 hover:text-blue-800 focus:outline-none focus:bg-blue-100 focus:text-blue-800 disabled:opacity-50 disabled:pointer-events-none dark:text-blue-500 dark:hover:bg-blue-800/30 dark:hover:text-blue-400 dark:focus:bg-blue-800/30 dark:focus:text-blue-400">
                                            Update Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endrole
            <!-- End: Nested accordion -->
        </div>
        </div>
    </div>
</div>

@push('scripts')
    @vite(['resources/js/external/viewPass.js'])
@endpush

