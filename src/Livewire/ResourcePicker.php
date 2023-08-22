<?php

namespace Codedor\FilamentResourcePicker\Livewire;

use Illuminate\Support\Collection;
use Livewire\Component;

class ResourcePicker extends Component
{
    public Collection $resources;

    public string $displayType;

    public string $statePath;

    public string $keyField;

    public string $labelField;

    public array $state = [];

    public bool $isMultiple;

    public bool $isGrid;

    public function render()
    {
        return view('filament-resource-picker::livewire.resource-picker', [
            'isList' => ! $this->isGrid,
        ]);
    }
}
