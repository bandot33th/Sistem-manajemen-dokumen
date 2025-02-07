<div>
    <div id="history-view-modal" tabindex="-1" aria-hidden="true"
        class="fixed inset-0 z-50 flex items-center justify-center w-full bg-black bg-opacity-50">
        <div class="relative w-full max-w-2xl max-h-full p-4">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b rounded-t md:p-5 dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Activity Detail
                    </h3>
                    <button type="button"
                        class="inline-flex items-center justify-center w-8 h-8 text-sm text-gray-400 bg-transparent rounded-lg hover:bg-gray-200 hover:text-gray-900 ms-auto dark:hover:bg-gray-600 dark:hover:text-white"
                        wire:click="closeModal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="max-w-5xl p-4 space-y-4 md:p-5">
                    <div class="flow-root">
                        <div
                            class="p-5 mb-4 border border-gray-100 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                            <time class="text-lg font-semibold text-gray-900 dark:text-white">
                                {!! \Carbon\Carbon::parse($activity->updated_at)->format('F') !!}
                                {!! \Carbon\Carbon::parse($activity->updated_at)->format('j') !!}<sup>{!!
                                    \Carbon\Carbon::parse($activity->updated_at)->format('S') !!}</sup>,
                                {!! \Carbon\Carbon::parse($activity->updated_at)->format('Y') !!}
                            </time>
                            <ol class="mt-3 divide-y divider-gray-200 dark:divide-gray-700">
                                <li>
                                    <a href="#"
                                        class="items-center block p-3 sm:flex hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <img class="w-12 h-12 mb-3 rounded-full me-3 sm:mb-0"
                                            src="{{ Auth::user()->profile_photo_url }}" alt="photo profile"
                                            loading="lazy" />
                                        <div class="text-gray-600 dark:text-gray-400">
                                            <div class="text-base font-normal">
                                                <span class="font-medium text-gray-900 dark:text-white"> {{
                                                    class_basename($activity->subject_type) }} {{ $activity->event
                                                    }}
                                                </span>
                                            </div>
                                            <div class="text-sm font-normal">"{{
                                                \Carbon\Carbon::parse($activity->created_at)->diffForHumans() }}."
                                            </div>
                                            <span
                                                class="inline-flex items-start text-xs font-normal text-gray-500 dark:text-gray-400">
                                                <svg class="w-3 h-3 text-gray-800 me-1 dark:text-white"
                                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" fill="currentColor" viewBox="0 0 24 24">
                                                    <path fill-rule="evenodd"
                                                        d="M12 20a7.966 7.966 0 0 1-5.002-1.756l.002.001v-.683c0-1.794 1.492-3.25 3.333-3.25h3.334c1.84 0 3.333 1.456 3.333 3.25v.683A7.966 7.966 0 0 1 12 20ZM2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 5.5-4.44 9.963-9.932 10h-.138C6.438 21.962 2 17.5 2 12Zm10-5c-1.84 0-3.333 1.455-3.333 3.25S10.159 13.5 12 13.5c1.84 0 3.333-1.455 3.333-3.25S13.841 7 12 7Z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                                by {{ $activity->causer->name }}
                                            </span>
                                        </div>
                                    </a>
                                </li>

                                @if($properties)
                                <li>
                                    <a class="items-center block p-3 sm:flex hover:bg-gray-100 dark:hover:bg-gray-700">
                                        <div>
                                            <div class="text-base font-normal text-gray-600 dark:text-gray-400">
                                                {{-- document desctiption --}}
                                                @if(class_basename($activity->subject_type) == 'Document')
                                                <span class="font-medium text-gray-900 dark:text-white">
                                                    Document <span
                                                        class="inline-block max-w-full break-all">{{$properties->doc_name}}</span>
                                                    was {{ $activity->event }}ed.
                                                </span>
                                                <p>at : {{ $properties->created_at->format('H:i:s') }}</p>

                                                {{-- folder desctiption --}}
                                                @elseif (class_basename($activity->subject_type) ==
                                                'Folder')
                                                <span class="font-medium text-gray-900 dark:text-white">
                                                    Folder {{$properties->name}} was {{ $activity->event }}d.
                                                </span>
                                                <p>at : {{ $properties->created_at->format('H:i:s') }}</p>

                                                {{-- user desctiption --}}
                                                @elseif (class_basename($activity->subject_type) == 'User')
                                                <span class="font-medium text-gray-900 dark:text-white">
                                                    User {{$properties->name}} from {{ $properties->department }}
                                                    has been {{ $activity->event }}d.
                                                </span>
                                                <p>Email : {{ $properties->email }}</p>
                                                <span>Folder Access : </span>
                                                @if($properties->permissions->isNotEmpty())
                                                @foreach ($properties->permissions as $permission)
                                                @php
                                                $words = explode('-', $permission->name);
                                                array_shift($words);
                                                $permissionName = implode('-', $words);
                                                @endphp
                                                <p
                                                    class="inline-block px-2 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded-full">
                                                    {{ $permissionName }}
                                                    @endforeach
                                                    @endif
                                                </p>
                                                @endif
                                            </div>
                                            <span
                                                class="inline-flex items-center text-xs font-normal text-gray-500 dark:text-gray-400">
                                            </span>
                                        </div>
                                    </a>
                                </li>
                                @endif
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>