@php
    $statePath = $getStatePath();
    $selected = $getStateAsResources();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    x-on:picked-resource.window="(event) => {
        // Set the state only if the event is for this resource picker
        if (event.detail.statePath !== '{{ $statePath }}') return
        $wire.$set(event.detail.statePath, event.detail.resources)
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
                    >
                        {{ $item->{$getLabelField()} }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    <div>
        @if ($selected->isNotEmpty())
            {{ $getAction('clear-selection') }}
        @endif

        {{ $getAction('open-resource-picker') }}
    </div>
</x-dynamic-component>
