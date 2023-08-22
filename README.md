# Filament Resource Picker

```php
ResourcePickerInput::make('location_id')
    ->label('Location')
    ->query(fn ($query) => $query->orderBy('id', 'desc'))
    ->resource(LocationResource::class)
    ->labelField('working_title')
    ->grid(),
```
