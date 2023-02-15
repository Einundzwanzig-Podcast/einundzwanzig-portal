<?=
/* Using an echo tag here so the `<? ... ?>` won't get parsed as short tags */
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0" xmlns:media="http://search.yahoo.com/mrss/">
    <channel>
        <atom:link href="{{ url($meta['link']) }}" rel="self" type="application/rss+xml"/>
        <title>{!! \Spatie\Feed\Helpers\Cdata::out($meta['title'] ) !!}</title>
        <link>{!! \Spatie\Feed\Helpers\Cdata::out(url($meta['link']) ) !!}</link>
        @if(!empty($meta['image']))
            <image>
                <url>{{ $meta['image'] }}</url>
                <title>{!! \Spatie\Feed\Helpers\Cdata::out($meta['title'] ) !!}</title>
                <link>{!! \Spatie\Feed\Helpers\Cdata::out(url($meta['link']) ) !!}</link>
            </image>
        @endif
        <description>{!! \Spatie\Feed\Helpers\Cdata::out($meta['description'] ) !!}</description>
        <language>{{ $meta['language'] }}</language>
        <pubDate>{{ $meta['updated'] }}</pubDate>

        @foreach($items as $item)
            <item>
                <title>{!! \Spatie\Feed\Helpers\Cdata::out($item->title) !!}</title>
                <link>{{ url($item->link) }}</link>
                <description>{!! \Spatie\Feed\Helpers\Cdata::out($item->summary) !!}</description>
                <author>{!! \Spatie\Feed\Helpers\Cdata::out($item->authorName.(empty($item->authorEmail)?'':' <'.$item->authorEmail.'>')) !!}</author>
                <guid isPermaLink="true">{{ url($item->id) }}</guid>
                <pubDate>{{ $item->timestamp() }}</pubDate>
                <content:encoded>
                    {{ app(Spatie\LaravelMarkdown\MarkdownRenderer::class)->toHtml($item->content) }}
                </content:encoded>
                @if($item->__isset('enclosure'))
                    <enclosure url="{{ url($item->enclosure) }}" length="{{ url($item->enclosureLength) }}" type="{{ $item->enclosureType }}"/>
                    <media:content url="{{ url($item->enclosure) }}" medium="image" type="{{ $item->enclosureType }}"/>
                @endif
                @foreach($item->category as $category)
                    <category>{{ $category }}</category>
                @endforeach
            </item>
        @endforeach
    </channel>
</rss>
