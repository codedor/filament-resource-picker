<?php

namespace Codedor\FilamentResourcePicker\Livewire;

use Codedor\FilamentResourcePicker\ResourceQuery;
use Illuminate\Support\Arr;
use Livewire\Component;

class ResourcePicker extends Component
{
    public string $resourceClass;

    public $items = [];

    public string $displayType;

    public string $statePath;

    public string $keyField;

    public string $labelField;

    public array $state = [];

    public bool $isMultiple;

    public bool $isGrid;

    public int $gridColumns;

    public ?int $minItems = null;

    public ?int $maxItems = null;

    public string $search = '';

    public function mount(
        string $resourceClass,
        string $displayType,
        string $statePath,
        string $keyField,
        string $labelField,
        array $state,
        bool $isMultiple,
        bool $isGrid,
        int $gridColumns,
        ?int $minItems = null,
        ?int $maxItems = null,
    ) {
        $this->resourceClass = $resourceClass;
        $this->displayType = $displayType;
        $this->statePath = $statePath;
        $this->keyField = $keyField;
        $this->labelField = $labelField;
        $this->state = Arr::wrap($state);
        $this->isMultiple = $isMultiple;
        $this->isGrid = $isGrid;
        $this->gridColumns = $gridColumns;
        $this->minItems = $minItems;
        $this->maxItems = $maxItems;

        $this->items = $this->getItems();
    }

    public function render()
    {
        return view('filament-resource-picker::livewire.resource-picker', [
            'isList' => ! $this->isGrid,
            'hasSearch' => method_exists($this->resourceClass, ResourceQuery::resourcePickerQueryMethod),
        ]);
    }

    public function getItems(int $offset = 0)
    {
        return ResourceQuery::get($this->resourceClass, $this->search)
            ->latest()
            ->offset($offset)
            ->limit(24)
            ->get();
    }

    public function getItemCount()
    {
        return ResourceQuery::get($this->resourceClass, $this->search)
            ->count();
    }

    public function loadMoreItems(): void
    {
        $this->items = [
            ...$this->items,
            ...$this->getItems(count($this->items)),
        ];
    }

    public function updatedSearch(): void
    {
        $this->items = $this->getItems();
    }
}
