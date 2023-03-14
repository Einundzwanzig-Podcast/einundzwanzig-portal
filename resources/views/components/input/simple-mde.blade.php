<div
    wire:ignore
    x-data="{
        value: @entangle($attributes->wire('model')).defer,
        init() {
            let editor = new EasyMDE({
                element: this.$refs.editor,
                lineNumbers: true,
                uploadImage: false,
                spellChecker: false,
{{--                imageMaxSize: 1024 * 1024 * 10,--}}
{{--                imageUploadFunction: (file, onSuccess, onError) => {--}}
{{--                    @this.upload('images', file, (uploadedFilename) => {--}}
{{--                        const currentImage = @this.get('currentImage');--}}
{{--                        const temporaryUrls = @this.get('temporaryUrls');--}}
{{--                        onSuccess(temporaryUrls[currentImage]);--}}
{{--                        @this.set('currentImage', currentImage + 1)--}}
{{--                    }, () => {--}}
{{--                        // Error callback.--}}
{{--                    }, (event) => {--}}
{{--                        // Progress callback.--}}
{{--                        // event.detail.progress contains a number between 1 and 100 as the upload progresses.--}}
{{--                    })--}}
{{--                },--}}
                showIcons: [
                    'heading',
                    'heading-smaller',
                    'heading-bigger',
                    'heading-1',
                    'heading-2',
                    'heading-3',
                    'code',
                    'table',
                    'quote',
                    'strikethrough',
                    'unordered-list',
                    'ordered-list',
                    'clean-block',
                    'horizontal-rule',
                    'undo',
                    'redo',
                    //'upload-image',
                ],
            })

            editor.value(this.value)

            editor.codemirror.on('change', () => {
                this.value = editor.value()
            })
        },
    }"
    class="w-full"
>
    <div class="prose max-w-none">
        <textarea x-ref="editor"></textarea>
    </div>
    <style>
        .EasyMDEContainer {
            background-color: white;
        }
    </style>
</div>
