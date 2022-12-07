@if($writable)
    @can('createComment', $model)
        <div class="comments-form">
            @if($showAvatars)
                <x-comments::avatar/>
            @endif
            <form class="comments-form-inner" wire:submit.prevent="comment">
                <x-dynamic-component
                    :component="\Spatie\LivewireComments\Support\Config::editor()"
                    model="text"
                    :placeholder="__('comments::comments.write_comment')"
                />
                @error('text')
                <p class="comments-error">
                    {{ $message }}
                </p>
                @enderror
                <x-comments::button submit>
                    {{ __('comments::comments.create_comment') }}
                </x-comments::button>
            </form>
        </div>
    @endcan
@endif
