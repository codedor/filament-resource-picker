@php
    $statePath = $getStatePath();
    $selected = $getStateAsResources();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    x-data="{
        isMultiple: {{ json_encode($isMultiple()) }},
    }"
    x-on:picked-resource.window="(event) => {
        // Set the state only if the event is for this resource picker
        if (event.detail.statePath !== '{{ $statePath }}') return
        $wire.$set(event.detail.statePath, event.detail.resources)

        if (! this.isMultiple) {
            $wire.dispatch('close-modal', {
                id: $wire.id + '-form-component-action',
            })
        }
    }"
>
    @if ($selected->isEmpty())
        <p>{{ __('filament-resource-picker::picker.nothing selected') }}</p>
    @else
        <div
            x-data="{
                state: $wire.entangle(@js($statePath)),
                dragging: false,
                reorder (event) {
                    this.dragging = false
                    this.state = event.to.sortable.toArray()
                },
            }"
        >
            <ul
                @if ($isMultiple() && ! $isDisabled())
                    x-sortable
                    x-on:end="reorder($event)"
                    x-on:start="dragging = true"
                    x-bind:class="dragging ? 'gallery--dragging' : ''"
                @endif
            >
                @foreach ($getStateAsResources() as $item)
                    <li
                        x-sortable-handle
                        x-sortable-item="{{ $item->getKey() }}"
                        class="text-sm my-2"
                    >
                        <span class="flex items-center">
                            <x-filament::icon-button
                                icon="heroicon-o-bars-2"
                                type="button"
                                color="gray"
                                size="sm"
                                class="cursor-move"
                            />
                            <p class="ml-2">{{ $item->{$getLabelField()} }}</p>
                        </span>
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div @class(['flex gap-4', 'mt-3' => count($getStateAsResources())])>
        {{ $getAction('open-resource-picker') }}

        @if ($selected->isNotEmpty())
            {{ $getAction('clear-selection') }}
        @endif
    </div>
</x-dynamic-component>
