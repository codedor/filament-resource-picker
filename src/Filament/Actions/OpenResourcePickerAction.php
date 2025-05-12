<?php

namespace Codedor\FilamentResourcePicker\Filament\Actions;

use Codedor\FilamentResourcePicker\Filament\Forms\Components\ResourcePickerInput;
use Filament\Forms\Components\Actions\Action;

class OpenResourcePickerAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'open-resource-picker';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->label(__('filament-resource-picker::picker.open modal'));
        $this->modalHeading(__('filament-resource-picker::picker.modal heading'));

        $this->modalSubmitAction(false);
        $this->modalCancelAction(false);

        $this->modalContent(static function (ResourcePickerInput $component) {
            return view('filament-resource-picker::picker', [
                'resourceClass' => $component->getResource(),
                'displayType' => $component->getDisplayType(),
                'statePath' => $component->getStatePath(),
                'state' => $component->getState() ?? [],
                'keyField' => $component->getKeyField(),
                'labelField' => $component->getLabelField(),
                'isMultiple' => $component->isMultiple(),
                'isGrid' => $component->isGrid(),
                'gridColumns' => $component->gridColumns(),
            ]);
        });
    }
}
