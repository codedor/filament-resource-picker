<label
    class="p-2
        bg-white rounded-xl shadow-sm ring-1 ring-gray-950/5
        cursor-pointer
        transition duration-75
        hover:bg-gray-50
        dark:bg-gray-900 dark:hover:bg-white/10 dark:hover:ring-white/20 dark:bg-white/5 dark:ring-white/10
    "
    for="resource-picker::{{ $statePath }}-{{ $item->{$keyField} }}"
>
    <div class="flex items-baseline h-full">
        {{ $slot }}
        <div class="ml-2 pl-2 flex flex-col justify-between">
            <div class="text-sm">
                {{ $item->{$labelField} }}
            </div>
            {{-- <div>
                <div
                    class="min-h-6 px-2 py-0.5 inline-flex items-center justify-center space-x-1 mt-2
                        text-custom-700 text-sm font-medium tracking-tight
                        bg-custom-500/10 rounded-xl whitespace-nowrap
                        rtl:space-x-reverse
                        dark:text-custom-500"
                    style="{{ $item->online
                            ? '--c-500:var(--success-500);--c-700:var(--success-700);'
                            : '--c-500:var(--danger-500);--c-700:var(--danger-700);' }}"
                >
                    @if ($item->online)
                        Online
                    @else
                        Offline
                    @endif
                </div>
            </div> --}}
        </div>
    </div>
</label>
