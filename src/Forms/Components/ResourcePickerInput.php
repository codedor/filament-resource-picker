<?php

namespace Codedor\FilamentResourcePicker\Forms\Components;

use Closure;
use Codedor\FilamentResourcePicker\Actions\OpenResourcePickerAction;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Field;
use Filament\Forms\Set;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ResourcePickerInput extends Field
{
    protected string $view = 'filament-resource-picker::forms.components.resource-picker-input';

    public string|Closure $resource;

    public string|Closure $keyField = 'id';

    public string|Closure $labelField = 'id';

    public string|Closure $displayType = 'list';

    public bool|Closure $multiple = false;

    public Closure $query;

    public function setUp(): void
    {
        $this->query(fn (Builder $query) => $query);

        $this->registerActions([
            OpenResourcePickerAction::make(),

            Action::make('clear-selection')
                ->label(__('filament-resource-picker::picker.clear selection'))
                ->action(fn (Set $set) => $set($this->getStatePath(false), []))
                ->color('gray'),
        ]);
    }

    public function grid(): self
    {
        return $this->displayType('grid');
    }

    public function displayType(string|Closure $displayType): self
    {
        $this->displayType = $displayType;

        return $this;
    }

    public function getDisplayType(): string
    {
        return $this->evaluate($this->displayType);
    }

    public function keyField(string|Closure $keyField): self
    {
        $this->keyField = $keyField;

        return $this;
    }

    public function getKeyField(): string
    {
        return $this->evaluate($this->keyField);
    }

    public function labelField(string|Closure $labelField): self
    {
        $this->labelField = $labelField;

        return $this;
    }

    public function getLabelField(): string
    {
        return $this->evaluate($this->labelField);
    }

    public function multiple(bool|Closure $multiple = true): self
    {
        $this->multiple = $multiple;

        return $this;
    }

    public function isMultiple(): bool
    {
        return $this->evaluate($this->multiple);
    }

    public function resource(string|Closure $resource): self
    {
        $this->resource = $resource;

        return $this;
    }

    public function getResource(): string
    {
        return $this->evaluate($this->resource);
    }

    public function query(Closure $callback): self
    {
        $this->query = $callback;

        return $this;
    }

    public function getQuery(): Builder
    {
        $model = (new ($this->getResource()))->getModel();

        return $this->evaluate($this->query, [
            'query' => $model::query()->withoutGlobalScopes(),
        ]);
    }

    public function getResources(): Collection
    {
        if (! isset($this->resource)) {
            throw new \Exception('Resource to pick not set');
        }

        return $this->getQuery()->get();
    }

    public function getStateAsResources(): Collection
    {
        return $this->getResources()->whereIn(
            $this->getKeyField(),
            $this->getState() ?? [],
        );
    }
}
