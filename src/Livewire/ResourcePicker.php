<?php

namespace Codedor\FilamentResourcePicker\Livewire;

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

    public string $search = '';

    public function mount(
        string $resourceClass,
        string $displayType,
        string $statePath,
        string $keyField,
        string $labelField,
        array $state,
        bool $isMultiple,
        bool $isGrid
    ) {
        $this->resourceClass = $resourceClass;
        $this->displayType = $displayType;
        $this->statePath = $statePath;
        $this->keyField = $keyField;
        $this->labelField = $labelField;
        $this->state = $state;
        $this->isMultiple = $isMultiple;
        $this->isGrid = $isGrid;

        $this->items = $this->getItems();
    }

    public function render()
    {
        return view('filament-resource-picker::livewire.resource-picker', [
            'isList' => ! $this->isGrid,
            'hasSearch' => method_exists($this->resourceClass, 'searchQuery'),
        ]);
    }

    public function getItems(int $offset = 0)
    {
        $query = $this->resourceClass::getEloquentQuery();

        if (method_exists($this->resourceClass, 'searchQuery')) {
            // Have to do this like this, since we can not access the
            // searchable columns without a HasTable Livewire component
            $query = $this->resourceClass::searchQuery($query, $this->search);
        }

        return $query
            ->latest()
            ->offset($offset)
            ->limit(20)
            ->get();
    }

    public function getItemCount()
    {
        $query = $this->resourceClass::getEloquentQuery();

        if (method_exists($this->resourceClass, 'searchQuery')) {
            // Have to do this like this, since we can not access the
            // searchable columns without a HasTable Livewire component
            $query = $this->resourceClass::searchQuery($query, $this->search);
        }

        return $query
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
