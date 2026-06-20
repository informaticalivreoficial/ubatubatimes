{{-- Anúncios --}}
@if (!empty($positionSidebarPost) && $positionSidebarPost->count() > 0)
    <div class="mb-6 flex flex-col gap-4">
        @foreach ($positionSidebarPost as $p)
            <a href="{{ $p->link ?? '#' }}" target="_blank" rel="noopener" class="block text-center">
                <img src="{{ $p->get300x250() }}" alt="{{ $p->title }}" class="mx-auto max-w-full rounded-lg">
            </a>
        @endforeach
    </div>
@else
    <div class="mb-6 flex flex-col gap-4">
        <div class="text-center">
            <x-ad slot="article_sidebar" />
        </div>
        <div class="text-center">
            <x-ad slot="article_sidebar_1" />
        </div>
    </div>
@endif

{{-- Veja também --}}
@if (!empty($postsMais) && $postsMais->count() > 0)
    <div class="mb-6">
        <h3 class="mb-4 border-b-2 border-slate-300 pb-2 text-base font-bold uppercase tracking-wide text-slate-700">
            Veja também
        </h3>
        <ul class="flex flex-col gap-4">
            @foreach ($postsMais as $postmais)
                <li>
                    <div class="flex gap-3">
                        <a href="{{ route($postmais->type == 'artigo' ? 'web.blog.artigo' : 'web.noticia', ['slug' => $postmais->slug]) }}"
                           class="block h-20 w-28 flex-shrink-0 overflow-hidden rounded-lg">
                            <img src="{{ $postmais->cover() }}" alt="{{ $postmais->title }}" class="h-full w-full object-cover">
                        </a>
                        <div class="min-w-0">
                            <h2 class="text-sm font-semibold leading-snug text-slate-900">
                                <a href="{{ route($postmais->type == 'artigo' ? 'web.blog.artigo' : 'web.noticia', ['slug' => $postmais->slug]) }}" class="hover:text-red-600">
                                    {{ $postmais->title }}
                                </a>
                            </h2>
                            <div class="mt-1 flex items-center gap-3 text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <i class="fa-solid fa-eye" aria-hidden="true"></i> {{ $postmais->views }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                    {{ \Carbon\Carbon::parse($postmais->created_at)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Categorias --}}
@if (!empty($categorias) && $categorias->count() > 0)
    <div class="mb-6">
        <h3 class="mb-4 border-b-2 border-slate-300 pb-2 text-base font-bold uppercase tracking-wide text-slate-700">
            Categorias
        </h3>
        <ul class="flex flex-col gap-1">
            @foreach ($categorias as $categoria)
                @if ($categoria->posts->count() >= 1)
                    <li>
                        <a href="{{ route($categoria->type == 'artigo' ? 'web.blog.categoria' : 'web.noticia.categoria', ['slug' => $categoria->slug]) }}"
                           class="flex items-center justify-between rounded-lg px-2 py-2 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-red-600">
                            <span>{{ $categoria->title }}</span>
                            <span class="text-xs text-slate-400">({{ $categoria->posts->count() }})</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
@endif

{{-- Tags --}}
@if (!empty($postsTags) && $postsTags->count() > 0)
    <div class="mb-6">
        <h3 class="mb-4 border-b-2 border-slate-300 pb-2 text-base font-bold uppercase tracking-wide text-slate-700">
            Tags populares
        </h3>
        <ul class="flex flex-wrap gap-2">
            @foreach ($postsTags as $posttags)
                @php $tagList = explode(',', $posttags->tags); @endphp
                @foreach ($tagList as $tagRaw)
                    @php $tag = trim($tagRaw); @endphp
                    @if ($tag !== '')
                        <li>
                            <a href="{{ route($posttags->type == 'artigo' ? 'web.blog.artigo' : 'web.noticia', ['slug' => $posttags->slug]) }}"
                               class="inline-block rounded-full border border-slate-200 px-3 py-1 text-xs text-slate-600 transition hover:border-red-300 hover:text-red-600">
                                {{ $tag }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endforeach
        </ul>
    </div>
@endif

{{-- Newsletter (desativado, mantido como no original) --}}
{{--
@if ($newsletterForm)
    ...
@endif
--}}

{{-- Plugin Facebook --}}
<div class="text-center">
    <div class="fb-root fb-widget">
        <div class="fb-page-responsive">
            <div data-href="{{ $config->facebook }}" data-tabs="timeline" data-height="500" data-small-header="false"
                 data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" class="fb-page">
                <div class="fb-xfbml-parse-ignore">
                    <blockquote cite="{{ $config->facebook }}">
                        <a href="{{ $config->facebook }}">{{ $config->nomedosite }}</a>
                    </blockquote>
                </div>
            </div>
        </div>
    </div>
</div>