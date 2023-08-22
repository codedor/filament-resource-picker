<label for="resource-picker::{{ $statePath }}-{{ $item->{$keyField} }}">
    <div style="display: none">
        {{ $slot }}
    </div>

    {{ $item->{$labelField} }}
</label>
