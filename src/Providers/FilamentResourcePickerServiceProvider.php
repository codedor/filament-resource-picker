<?php

namespace Codedor\FilamentResourcePicker\Providers;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentResourcePickerServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-resource-picker')
            ->setBasePath(__DIR__ . '/../');
    }
}
