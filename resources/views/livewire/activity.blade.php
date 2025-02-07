<div>

    @if(session()->has('success'))
    <x-partials.toast :timeout="2000" icon="success" type="success" message="{{ session('success') }}" />
    @elseif(session()->has('error'))
    <x-partials.toast :timeout="2000" icon="error" message="{{ session('error') }}" type="error" />
    @endif

    <div class="relative overflow-auto shadow-md sm:rounded-lg">
        <div class="flex flex-wrap items-center justify-between p-2 space-y-4 flex-column sm:flex-row sm:space-y-0">
            <div class="pb-1 bg-white dark:bg-gray-900">
                <x-partials.search />
            </div>
            <div class="inline-flex">
                @if($activities->isNotEmpty())
                <x-partials.export-button />
                <div class="inline-flex items-center space-x-2">
                    <x-partials.show-item />
                </div>
                @endif
            </div>
        </div>

        <table class="w-full text-sm text-left text-gray-500 rtl:text-right dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <x-partials.table-header title="No" />
                    <x-partials.table-header title="Type" fieldName="subject_type" :sortBy="$sortBy"
                        :sortDir="$sortDir" />
                    <x-partials.table-header title="Activity" fieldName="description" :sortBy="$sortBy"
                        :sortDir="$sortDir" />
                    <x-partials.table-header title="User" fieldName="causer_id" :sortBy="$sortBy" :sortDir="$sortDir" />
                    <x-partials.table-header title="Access Date" fieldName="created_at" :sortBy="$sortBy"
                        :sortDir="$sortDir" />
                    @role('Admin')
                    <x-partials.table-header title="Action" />
                    @endrole
                </tr>
            </thead>
            <tbody>
                @if($activities->isEmpty())
                <tr>
                    <td colspan="6" class="px-6 py-4 text-center text-gray-500 dark:text-gray-400">
                        There are no activity.
                    </td>
                </tr>
                @endif
                @foreach ($activities as $item)
                <tr wire:key="{{ $item->id }}"
                    class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <td class="p-3">
                        {{ ($activities->currentPage() - 1) * $activities->perPage() + $loop->iteration }}
                    </td>
                    <td class="px-3 py-4">
                        {{ class_basename($item->subject_type) }}
                    </td>
                    <th scope="col" class="px-3 py-3 max-w-md">
                        {{ $item->description }}
                    </th>
                    @php
                    $causerName = $item->causer->name ?? 'Unknown';
                    @endphp
                    <td class="px-3 py-4">
                        {{ $causerName }}
                    </td>
                    <td class="px-3 py-4">
                        {{ date('d/m/Y H:i:s', strtotime($item->updated_at)); }}
                    </td>
                    @role('Admin')
                    <td class="inline-flex gap-3 px-3 py-4">
                        <a wire:click="selectDelete({{ $item->id }})"
                            class=" font-semibold text-red-600 cursor-pointer hover:text-red-700">
                            Delete
                        </a>
                    </td>
                    @endrole
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="p-4 pl-0 ml-4">
            {{ $activities->links() }}
        </div>

        @if($isDelete)
        <x-partials.delete-modal title="Delete selected items" action="delete" params="isDelete" />
        @endif
    </div>
</div>
