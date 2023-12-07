<?php

namespace Codedor\FilamentResourcePicker\Providers;

use App\Models\Location;
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
            ->hasViews();
    }

    public function packageBooted(): void
    {
        \Illuminate\Database\Query\Builder::macro('resources', function (array $ids = []) {
            /** @var \Illuminate\Database\Eloquent\Builder $this */
            if (! $ids) {
                return $this;
            }

            $idsString = collect($ids)->map(fn ($id) => "'{$id}'")->join(',');

            $this->whereIn('id', $ids)
                ->orderByRaw("FIELD(id, {$idsString})");

            return $this;
        });

        foreach ($this->livewireComponents as $key => $livewireComponent) {
            Livewire::component("{$this->packageName()}::$key", $livewireComponent);
        }
    }
}
