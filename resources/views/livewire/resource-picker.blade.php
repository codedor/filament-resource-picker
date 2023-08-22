<div x-data="{
    state: @entangle('state'),
    submit () {
        $wire.dispatch('picked-resource', {
            statePath: '{{ $statePath }}',
            resources: this.state,
        })

        this.close()
    },
}">
    <div @class([
        'gap-4',
        'grid grid-cols-4' => $isGrid,
        'flex flex-col' => $isList,
    ])>
        @foreach ($resources as $resource)
            <x-dynamic-component
                :component="'filament-resource-picker::items.' . $displayType"
                :item="$resource"
                :key-field="$keyField"
                :label-field="$labelField"
                :state-path="$statePath"
            >
                <input
                    id="resource-picker::{{ $statePath }}-{{ $resource->{$keyField} }}"
                    type="checkbox"
                    x-model="state"
                    value="{{ $resource->{$keyField} }}"
                >
            </x-dynamic-component>
        @endforeach
    </div>

    <div class="fi-modal-footer w-full pt-6">
        <div class="fi-modal-footer-actions gap-3 flex flex-wrap items-center">
            <x-filament::button x-on:click.prevent="close" color="gray">
                {{ __('filament-resource-picker::picker.cancel picks') }}
            </x-filament::button>

            <x-filament::button x-on:click.prevent="submit">
                {{ __('filament-resource-picker::picker.select resources') }}
            </x-filament::button>
        </div>
    </div>
</div>
