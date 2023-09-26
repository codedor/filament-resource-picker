<label class="cursor-pointer" for="resource-picker::{{ $statePath }}-{{ $item->{$keyField} }}">
    {{ $slot }}

    <span class="ml-2">
        <span class="text-sm">{{ $item->{$labelField} }}</span>
        <span
            class="min-h-6 px-2 py-0.5 inline-flex items-center justify-center space-x-1 ml-2
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
        </span>
    </span>
</label>
