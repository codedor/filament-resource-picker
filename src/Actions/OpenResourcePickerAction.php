<?php

namespace Codedor\FilamentResourcePicker\Actions;

use Codedor\FilamentResourcePicker\Forms\Components\ResourcePickerInput;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\Field;

class OpenResourcePickerAction extends Action
{
    public static function getDefaultName(): ?string
    {
        return 'open-resource-picker';
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->modalHeading(__('filament-resource-picker::picker.modal heading'));

        $this->modalSubmitAction(false);
        $this->modalCancelAction(false);

        $this->modalContent(static function (Field $component) {
            return view('filament-resource-picker::picker', [
                'component' => $component,
            ]);
        });
    }
}
