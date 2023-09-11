<livewire:filament-resource-picker::resource-picker
    :resource-class="$resourceClass"
    :state-path="$statePath"
    :state="Arr::wrap($state ?? [])"

    :display-type="$displayType"
    :is-grid="$isGrid"

    :key-field="$keyField"
    :label-field="$labelField"

    :is-multiple="$isMultiple"
/>
