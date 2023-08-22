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
        <ul>
            @foreach ($getStateAsResources() as $item)
                <li>{{ $item->{$getLabelField()} }}</li>
            @endforeach
        </ul>
    @endif

    <div>
        @if ($selected->isNotEmpty())
            {{ $getAction('clear-selection') }}
        @endif

        {{ $getAction('open-resource-picker') }}
    </div>
</x-dynamic-component>
