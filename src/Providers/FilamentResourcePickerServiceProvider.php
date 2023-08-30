<?php

namespace Codedor\FilamentResourcePicker\Providers;

use Codedor\FilamentResourcePicker\Livewire\ResourcePicker;
use Livewire\Livewire;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentResourcePickerServiceProvider extends PackageServiceProvider
{
    protected array $livewireComponents = [
        'resource-picker' => ResourcePicker::class,
    ];

    public function packageName(): string
    {
        return 'filament-resource-picker';
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name($this->packageName())
            ->hasTranslations()
            ->setBasePath(__DIR__ . '/../')
            ->hasRoute('web')
            ->hasViews();
    }

    public function packageBooted(): void
    {
        foreach ($this->livewireComponents as $key => $livewireComponent) {
            Livewire::component("{$this->packageName()}::$key", $livewireComponent);
        }
    }
}
