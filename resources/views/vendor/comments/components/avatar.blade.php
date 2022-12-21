@php
    $defaultImage = Spatie\Comments\Support\Config::getGravatarDefaultImage();
    $defaultAvatar = "https://www.gravatar.com/avatar/unknown?d={$defaultImage}";

    if ($user = auth()->user()) {
        $segment = md5(strtolower($user->email));
        $defaultAvatar = "https://www.gravatar.com/avatar/{$segment}?d={$defaultImage}";
    }
@endphp

{{--<img
    class="comments-avatar"
    src="{{ isset($comment) &&  $comment->commentatorProperties() ? $comment->commentatorProperties()->avatar : $defaultAvatar }}"
    alt="avatar"
>--}}
