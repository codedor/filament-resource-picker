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
                class="list-disc px-3"
            >
                @foreach ($getStateAsResources() as $item)
                    <li
                        x-sortable-handle
                        x-sortable-item="{{ $item->getKey() }}"
                        class="text-sm mb-2 cursor-pointer"
                    >
                        <span class="flex items-center">
                            <button
                                class="fi-icon-btn fi-color-gray fi-ac-icon-btn-action
                                    relative
                                    flex items-center justify-center h-7 w-7
                                    text-gray-400
                                    rounded-lg
                                    outline-none
                                    transition duration-75
                                    focus:ring-2 focus:ring-primary-600
                                    hover:text-gray-500
                                    disabled:pointer-events-none disabled:opacity-70
                                    dark:text-gray-500 dark:hover:text-gray-400 dark:focus:ring-primary-500"
                                type="button"
                            >
                                <x-heroicon-o-arrows-up-down
                                    class="fi-icon-btn-icon h-4 w-4"
                                />
                            </button>
                            {{ $item->{$getLabelField()} }}
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
