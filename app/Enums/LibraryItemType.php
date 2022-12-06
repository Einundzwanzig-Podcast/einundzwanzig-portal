<?php

namespace App\Enums;

use ArchTech\Enums\From;
use ArchTech\Enums\InvokableCases;
use ArchTech\Enums\Options;
use ArchTech\Enums\Values;

enum LibraryItemType: string
{
    use InvokableCases;
    use Values;
    use Options;
    use From;

    case Book = 'book';
    case BlogArticle = 'blog_article';
    case MarkdownArticle = 'markdown_article';
    case YoutubeVideo = 'youtube_video';
    case VimeoVideo = 'vimeo_video';
    case PodcastEpisode = 'podcast_episode';
    case DownloadableFile = 'downloadable_file';

    public static function labels(): array
    {
        return [
            'book'              => __('Book'),
            'blog_article'      => __('Article'),
            'markdown_article'  => __('Markdown Article'),
            'youtube_video'     => __('Youtube Video'),
            'vimeo_video'       => __('Vimeo Video'),
            'podcast_episode'   => __('Podcast Episode'),
            'downloadable_file' => __('Downloadable File'),
        ];
    }

    public static function icons(): array
    {
        return [
            'book'              => 'book',
            'blog_article'      => 'newspaper',
            'markdown_article'  => 'newspaper',
            'youtube_video'     => 'video',
            'vimeo_video'       => 'video',
            'podcast_episode'   => 'podcast',
            'downloadable_file' => 'download',
        ];
    }
}
