<div
    wire:ignore
    x-data
    x-init="
        FilePond.registerPlugin(
          FilePondPluginImagePreview,
          FilePondPluginImageExifOrientation,
          FilePondPluginFileValidateSize,
          FilePondPluginImageEdit
        );
        FilePond.setOptions({
            labelIdle: '{{ 'Drag & Drop Deiner Dateien oder <span class="filepond--label-action"> in Ordner suchen </span>' }}',
            allowMultiple: {{ isset($attributes['multiple']) ? 'true' : 'false' }},
            server: {
                process: (fieldName, file, metadata, load, error, progress, abort, transfer, options) => {
                    @this.upload('{{ $attributes['wire:model'] }}', file, load, error, progress)
                },
                revert: (filename, load) => {
                    @this.removeUpload('{{ $attributes['wire:model'] }}', filename, load)
                },
                load: (source, load, error, progress, abort, headers) => {
                  @this.load('{{ $attributes['wire:model'] }}', load, error, progress, abort, headers)
                },
            },
        });
        FilePond.create($refs.input);
    "
>
    <input type="file" x-ref="input" name="{{ $attributes['name'] }}">
</div>
