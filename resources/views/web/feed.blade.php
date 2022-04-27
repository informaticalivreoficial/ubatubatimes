<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title><![CDATA[ {{ $configuracoes->nomedosite }} ]]></title>
        <link><![CDATA[ {{url('feed')}} ]]></link>
        <description><![CDATA[ {{ $configuracoes->descricao }} ]]></description>
        <language>pt-br</language>
        <pubDate>{{ now() }}</pubDate>

        @foreach($posts as $post)
            <item>
                <title><![CDATA[{{ $post->titulo }}]]></title>
                <link>{{ url('blog/artigo/'.$post->slug) }}</link>
                <image>{{ $post->cover() }}</image>
                <description><![CDATA[{!! $post->getContentWebAttribute() !!}]]></description>
                <category>{{ $post->categoriaObject->titulo }}</category>
                <author><![CDATA[{{ $post->userObject->name }}]]></author>
                <guid>{{ $post->id }}</guid>
                <pubDate>{{ $post->created_at }}</pubDate>
            </item>
        @endforeach

        @foreach($paginas as $pagina)
            <item>
                <title><![CDATA[{{ $pagina->titulo }}]]></title>
                <link>{{ url('pagina/'.$pagina->slug) }}</link>
                <image>{{ $pagina->cover() }}</image>
                <description><![CDATA[{!! $pagina->getContentWebAttribute() !!}]]></description>
                <category>{{ $pagina->categoriaObject->titulo }}</category>
                <author><![CDATA[{{ $pagina->userObject->name }}]]></author>
                <guid>{{ $pagina->id }}</guid>
                <pubDate>{{ $pagina->created_at }}</pubDate>
            </item>
        @endforeach

        @foreach($noticias as $noticia)
            <item>
                <title><![CDATA[{{ $noticia->titulo }}]]></title>
                <link>{{ url('noticia/'.$noticia->slug) }}</link>
                <image>{{ $noticia->cover() }}</image>
                <description><![CDATA[{!! $noticia->getContentWebAttribute() !!}]]></description>
                <category>{{ $noticia->categoriaObject->titulo }}</category>
                <author><![CDATA[{{ $noticia->userObject->name }}]]></author>
                <guid>{{ $noticia->id }}</guid>
                <pubDate>{{ $noticia->created_at }}</pubDate>
            </item>
        @endforeach

        @if (!empty($empresas) && $empresas->count() > 0)
            @foreach($empresas as $empresa)
                <item>
                    <title><![CDATA[{{ $empresa->alias_name }}]]></title>
                    <link>{{ url('guia-ubatuba/'.$empresa->slug) }}</link>
                    <image>{{ $empresa->nologoCover() }}</image>
                    <description><![CDATA[{!! $empresa->getContentWebAttribute() !!}]]></description>
                    <category>{{ $empresa->categoriaObject->titulo }}</category>
                    <author><![CDATA[{{ $empresa->alias_name }}]]></author>
                    <guid>{{ $empresa->id }}</guid>
                    <pubDate>{{ $empresa->created_at }}</pubDate>
                </item>
            @endforeach
        @endif        
    </channel>
</rss>