<div
    id="comment-{{ $comment->id }}"
    class="comments-group"
    x-data="{ confirmDelete: false, urlCopied: false }"
    x-effect="
        if (urlCopied) {
            window.navigator.clipboard.writeText(window.location.href.split('#')[0] + '#comment-{{ $comment->id }}');
            window.setTimeout(() => urlCopied = false, 2000);
        }
    "
>
    <div class="comments-comment">
        @if($showAvatar)
            <x-comments::avatar :comment="$comment"/>
        @endif
        <div class="comments-comment-inner">
            <div class="comments-comment-header">
                @if($url = $comment->commentatorProperties()?->url)
                    <a href="{{ $url }}">
                        {{ $comment->commentatorProperties()->name }}
                    </a>
                @else
                    {{ $comment->commentatorProperties()?->name ?? __('comments::comments.guest')  }}
                @endif
                <ul class="comments-comment-header-actions">
                    <li>
                        <a
                            href="#comment-{{ $comment->id }}"
                            @click.prevent="urlCopied = true"
                        >
                            <x-comments::date :date="$comment->created_at"/>
                            <span class="comments-comment-header-copied" x-show="urlCopied" style="display: none;">
                                ✓ {{ __('comments::comments.copied') }}!
                            </span>
                        </a>
                    </li>
                    @if($writable)
                        @can('update', $comment)
                            <li>
                                <a href="#" wire:click.prevent="startEditing" aria-role="button">{{__('comments::comments.edit')}}</a>
                            </li>
                        @endcan
                        @can('delete', $comment)
                            <li>
                                <a href="#" @click.prevent="confirmDelete = true" aria-role="button">{{__('comments::comments.delete')}}</a>
                                <x-comments::modal
                                    right
                                    bottom
                                    x-show="confirmDelete"
                                    @click.outside="confirmDelete = false"
                                    :title="__('comments::comments.delete_confirmation_title')"
                                >
                                    <p>{{ __('comments::comments.delete_confirmation_text') }}</p>
                                    <x-comments::button danger small wire:click="deleteComment">
                                        {{ __('comments::comments.delete') }}
                                    </x-comments::button>
                                </x-comments::modal>
                            </li>
                        @endcan
                    @endif
                    @include('comments::extraCommentHeaderActions')
                </ul>
            </div>
            @if($comment->isPending())
                <div class="comments-approval">
                    <span>
                        {{__('comments::comments.awaits_approval')}}
                    </span>
                    <span class="comments-approval-buttons">
                        @can('reject', $comment)
                            <button
                                class="comments-button is-small is-danger"
                                wire:click="reject">
                                {{__('comments::comments.reject_comment')}}
                            </button>
                        @endcan
                        @can('approve', $comment)
                            <button
                                class="comments-button is-small"
                                wire:click="approve">
                                {{__('comments::comments.approve_comment')}}
                            </button>
                        @endcan
                    </span>
                </div>
            @endif
            @if($isEditing)
                <div class="comments-form">
                    <form class="comments-form-inner" wire:submit.prevent="edit">
                        <x-dynamic-component
                            :component="\Spatie\LivewireComments\Support\Config::editor()"
                            model="editText"
                            :comment="$comment"
                            autofocus
                        />
                        @error('editText')
                        <p class="comments-error">
                            {{ $message }}
                        </p>
                        @enderror
                        <x-comments::button submit>
                            {{ __('comments::comments.edit_comment') }}
                        </x-comments::button>
                        <x-comments::button link wire:click="stopEditing">
                            {{ __('comments::comments.cancel') }}
                        </x-comments::button>
                    </form>
                </div>
            @else
                <div class="comment-text">
                    {!! $comment->text !!}
                </div>
                @if($writable || $comment->reactions->summary()->isNotEmpty())
                    <div class="comments-reactions">
                        @foreach($comment->reactions->summary() as $summary)
                            <div
                                wire:key="{{ $comment->id }}{{$summary['reaction']}}"
                                @auth
                                wire:click="toggleReaction('{{ $summary['reaction'] }}')"
                                @endauth
                                @class(['comments-reaction', 'is-reacted' => $summary['commentator_reacted']])
                            >
                                {{ $summary['reaction'] }} {{ $summary['count'] }}
                            </div>
                        @endforeach
                        @if($writable)
                            <div
                                x-cloak
                                x-data="{ open: false }"
                                @click.outside="open = false"
                                class="comments-reaction-picker"
                            >
                                @can('react', $comment)
                                    <button class="comments-reaction-picker-trigger" type="button"
                                            @click="open = !open">
                                        <x-comments::icons.smile/>
                                    </button>
                                    <x-comments::modal x-show="open" compact left>
                                        <div class="comments-reaction-picker-reactions">
                                            @foreach(config('comments.allowed_reactions') as $reaction)
                                                @php
                                                    $commentatorReacted = ! is_bool(array_search(
                                                        $reaction,
                                                        array_column($comment->reactions->toArray(), 'reaction'),
                                                    ));
                                                @endphp
                                                <button
                                                    type="button"
                                                    @class(['comments-reaction-picker-reaction', 'is-reacted' => $commentatorReacted])
                                                    wire:click="toggleReaction('{{ $reaction }}')"
                                                >
                                                    {{ $reaction }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </x-comments::modal>
                                @endcan
                            </div>
                        @endif
                    </div>
                @endif
            @endif
        </div>
    </div>

    @if($showReplies)

        @if($comment->isTopLevel())

            <div class="comments-nested">
                @if($this->newestFirst)
                    @if(auth()->check() || config('comments.allow_anonymous_comments'))
                        @include('comments::livewire.partials.replyTo')
                    @endif

                @endif
                @foreach ($comment->nestedComments as $nestedComment)
                    @can('see', $nestedComment)
                        <livewire:comments-comment
                            :key="$nestedComment->id"
                            :comment="$nestedComment"
                            :show-avatar="$showAvatar"
                            :newest-first="$newestFirst"
                            :writable="$writable"
                        />
                    @endcan
                @endforeach
                @if(! $this->newestFirst)
                    @if(auth()->check() || config('comments.allow_anonymous_comments'))
                        @include('comments::livewire.partials.replyTo')
                    @endif
                @endif
            </div>
        @endif
    @endif
</div>
