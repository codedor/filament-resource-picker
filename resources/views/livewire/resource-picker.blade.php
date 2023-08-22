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
    <div @class([
        'gap-4',
        'grid grid-cols-6' => $isGrid,
        'flex flex-col' => $isList,
    ])>
        @foreach ($resources as $resource)
            <x-dynamic-component
                :component="$displayType"
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
                    x-on:change="updatedState"
                >
            </x-dynamic-component>
        @endforeach
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
