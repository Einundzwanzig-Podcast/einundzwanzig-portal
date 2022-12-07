@if($writable)
    <div class="comments-form comments-reply">
        @if($showAvatar)
            <x-comments::avatar/>
        @endif
        <form class="comments-form-inner" wire:submit.prevent="reply">
            <div
                x-data="{ isExpanded: false }"
                x-init="
                    $wire.on('reply-{{ $comment->id }}', () => {
                        isExpanded = false;
                    });
                "
            >
                <input
                    x-show="!isExpanded"
                    @click="isExpanded = true"
                    @focus="isExpanded = true"
                    class="comments-placeholder"
                    placeholder="{{ __('comments::comments.write_reply') }}"
                >
                <div x-show="isExpanded">
                    <div>
                        <x-dynamic-component
                            :component="\Spatie\LivewireComments\Support\Config::editor()"
                            model="replyText"
                            :comment="$comment"
                            :placeholder="__('comments::comments.write_reply')"
                            autofocus
                        />
                        @error('replyText')
                        <p class="comments-error">
                            {{ $message }}
                        </p>
                        @enderror
                        <x-comments::button submit>
                            {{ __('comments::comments.create_reply') }}
                        </x-comments::button>
                        <x-comments::button link @click="isExpanded = false">
                            {{ __('comments::comments.cancel') }}
                        </x-comments::button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endif
