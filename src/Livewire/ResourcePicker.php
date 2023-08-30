<?php

namespace Codedor\FilamentResourcePicker\Livewire;

use Filament\Resources\Resource;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Livewire\Component;
use Livewire\WithPagination;

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
        ]);
    }

    public function getItems(int $offset = 0)
    {
        return $this->resourceClass::getEloquentQuery()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->latest()
            ->offset($offset)
            ->limit(2)
            ->get();
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
