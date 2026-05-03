<?= '<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL ?>
<rss version="2.0">
    <channel>
        <title><![CDATA[{{ $config->app_name }}]]></title>
        <link><![CDATA[{{ url('feed') }}]]></link>
        <description><![CDATA[{{ $config->information }}]]></description>
        <language>pt-br</language>
        <pubDate>{{ now() }}</pubDate>

        @foreach($noticias as $noticia)
            <item>
                <title><![CDATA[{{ $noticia->title }}]]></title>
                <link>{{ route('web.noticia', ['slug' => $noticia->slug]) }}</link>
                <image>{{ $noticia->cover() }}</image>
                <description><![CDATA[{!! $noticia->getContentWebAttribute() !!}]]></description>
                <category>{{ $noticia->categoryObject->title }}</category>
                <author><![CDATA[{{ $noticia->userObject->name }}]]></author>
                <guid>{{ $noticia->id }}</guid>
                <pubDate>{{ $noticia->created_at }}</pubDate>
            </item>
        @endforeach

        @foreach($artigos as $artigo)
            <item>
                <title><![CDATA[{{ $artigo->title }}]]></title>
                <link>{{ route('web.blog.artigo', ['slug' => $artigo->slug]) }}</link>
                <image>{{ $artigo->cover() }}</image>
                <description><![CDATA[{!! $artigo->getContentWebAttribute() !!}]]></description>
                <category>{{ $artigo->categoryObject->title }}</category>
                <author><![CDATA[{{ $artigo->userObject->name }}]]></author>
                <guid>{{ $artigo->id }}</guid>
                <pubDate>{{ $artigo->created_at }}</pubDate>
            </item>
        @endforeach

    </channel>
</rss>