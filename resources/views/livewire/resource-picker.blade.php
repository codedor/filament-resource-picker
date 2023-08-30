<div x-data="{
    state: @entangle('state'),
    isMultiple: @entangle('isMultiple'),
    submit () {
        $wire.dispatch('picked-resource', {
            statePath: '{{ $statePath }}',
            resources: this.state,
        })

        this.close()
    },
    updatedState () {
        if (! this.isMultiple) {
            this.state = [this.state[this.state.length - 1]]
            this.submit()
        }
    },
}">
    <label class="border border-gray-300 dark:border-gray-700 rounded-md relative flex items-center">
        <span class="sr-only">{{ __('filament-resource-picker::picker.search_label') }}</span>
        <x-filament::icon
            alias="curator::icons.check"
            icon="heroicon-s-magnifying-glass"
            class="w-4 h-4 absolute top-1.5 left-2 rtl:left-0 rtl:right-2 dark:text-gray-500"
        />
        <input
            type="search"
            placeholder="{{ __('filament-resource-picker::picker.search_placeholder') }}"
            wire:model.live.debounce.500ms="search"
            class="block w-full transition text-sm py-1 !ps-8 !pe-3 duration-75 border-none focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70 bg-transparent placeholder-gray-700 dark:placeholder-gray-400"
        />
        <svg fill="none" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="animate-spin h-4 w-4 text-gray-400 dark:text-gray-500 sm absolute right-2" wire:loading.delay wire:target="search">
            <path clip-rule="evenodd" d="M12 19C15.866 19 19 15.866 19 12C19 8.13401 15.866 5 12 5C8.13401 5 5 8.13401 5 12C5 15.866 8.13401 19 12 19ZM12 22C17.5228 22 22 17.5228 22 12C22 6.47715 17.5228 2 12 2C6.47715 2 2 6.47715 2 12C2 17.5228 6.47715 22 12 22Z" fill-rule="evenodd" fill="currentColor" opacity="0.2"></path>
            <path d="M2 12C2 6.47715 6.47715 2 12 2V5C8.13401 5 5 8.13401 5 12H2Z" fill="currentColor"></path>
        </svg>
    </label>

    <div @class([
        'gap-4',
        'grid grid-cols-6' => $isGrid,
        'flex flex-col' => $isList,
    ])>
        @foreach ($items as $item)
            <x-dynamic-component
                :component="$displayType"
                :item="$item"
                :key-field="$keyField"
                :label-field="$labelField"
                :state-path="$statePath"
            >
                <input
                    id="resource-picker::{{ $statePath }}-{{ $item->{$keyField} }}"
                    type="checkbox"
                    x-model="state"
                    value="{{ $item->{$keyField} }}"
                    x-on:change="updatedState"
                >
            </x-dynamic-component>
        @endforeach

        @if(count($items) < $this->getItemCount())
            <x-filament::button
                size="xs"
                color="gray"
                wire:click="loadMoreItems()"
            >
                {{ __('filament-resource-picker::picker.load more') }}
            </x-filament::button>
        @endif
    </div>

    <div class="fi-modal-footer w-full pt-6">
        <div class="fi-modal-footer-actions gap-3 flex flex-wrap items-center">
            <x-filament::button x-on:click.prevent="close" color="gray">
                {{ __('filament-resource-picker::picker.cancel picks') }}
            </x-filament::button>

            @if ($isMultiple)
                <x-filament::button x-on:click.prevent="submit">
                    {{ __('filament-resource-picker::picker.select resources') }}
                </x-filament::button>
            @endif
        </div>
    </div>
</div>
