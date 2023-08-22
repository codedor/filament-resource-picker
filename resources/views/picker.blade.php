<livewire:filament-resource-picker::resource-picker
    :resources="$component->getResources()"
    :display-type="$component->getDisplayType()"
    :state-path="$component->getStatePath()"
    :state="$component->getState() ?? []"
    :key-field="$component->getKeyField()"
    :label-field="$component->getLabelField()"
/>
