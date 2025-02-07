<div>
    <div id="delete-modal" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
        <div class="relative w-full max-w-md max-h-full p-4">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                        Download File
                    </h3>
                    <button type="button"
                        class="absolute top-3 right-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        wire:click="closeDownloadModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="flex flex-col px-5 pt-3 pb-5">
                    <form wire:submit="download">
                        @if ($this->errorDownloadMessages)
                            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-2 mb-2 text-sm" role="alert"" role="alert">
                                <p class="font-semibold">{{ $this->errorDownloadMessages }}</p>
                            </div>
                        @endif
                        <div class="mb-3">
                            <label for="UserEmail" class="block text-xs font-medium text-gray-700"> Document
                                Password </label>

                            <input type="password" id="UserEmail" placeholder="Insert Password Document"
                                class="w-full mt-1 mb-3 border-gray-200 rounded-md shadow-sm sm:text-sm"
                                wire:model="passwordInput" />
                        </div>
                        <div class="inline-flex w-full">
                            <button wire:click="closeDownloadModal" type="button"
                                class="w-full px-5 py-1.5 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg me-2 focus:outline-none hover:bg-gray-100 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                Cancel
                            </button>
                            <button type="submit"
                                class="w-full px-5 py-1.5 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800">
                                Confirm
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
