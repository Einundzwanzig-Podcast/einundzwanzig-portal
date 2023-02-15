<?php

namespace App\Support;

use Spatie\Feed\FeedItem;

class CustomFeedItem extends FeedItem
{
    protected string $content;

    public function content(string $content): self
    {
        $this->content = $content;

        return $this;
    }
}
