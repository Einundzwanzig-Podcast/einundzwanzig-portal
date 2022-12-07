<div
    x-cloak
    @class(['comments-modal', 'is-compact' => $compact ?? false, 'is-left' => $left ?? false, 'is-bottom' => $bottom ?? false])
    {{ $attributes }}
>
    @isset($title)
        <p class="comments-modal-title">
            {{ $title }}
        </p>
    @endisset
    <div class="comments-modal-contents">
        {{ $slot }}
    </div>
</div>
