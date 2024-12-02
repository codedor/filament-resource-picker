<livewire:filament-resource-picker::resource-picker
    :resource-class="$resourceClass"
    :state-path="$statePath"
    :state="Arr::wrap($state ?? [])"

    :display-type="$displayType"
    :is-grid="$isGrid"
    :grid-columns="$gridColumns"

    :key-field="$keyField"
    :label-field="$labelField"

    :is-multiple="$isMultiple"

    :min-items="$minItems ?? null"
    :max-items="$maxItems ?? null"

    :relation-filters="$relationFilters ?? null"
/>
