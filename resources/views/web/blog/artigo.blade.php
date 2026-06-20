@extends('web.master.master')

@section('content')

{{-- Breadcrumb --}}
<div class="border-b border-slate-200 bg-slate-50 py-4">
    <div class="mx-auto max-w-7xl px-4">
        <ul class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
            <li>
                <a href="{{ route('web.home') }}" class="hover:text-red-600 transition">Início</a>
            </li>
            <li class="flex items-center gap-2">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400" aria-hidden="true"></i>
                <span>{{ $post->type == 'noticia' ? 'Notícia' : 'Blog' }}</span>
            </li>
            <li class="flex items-center gap-2 max-w-xs truncate">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400" aria-hidden="true"></i>
                <span class="text-slate-800 font-medium truncate">{{ $post->title }}</span>
            </li>
        </ul>
    </div>
</div>

<section class="py-8">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">

            {{-- Coluna principal --}}
            <div class="lg:col-span-8">
                <article>

                    {{-- Cabeçalho do post --}}
                    <header class="mb-6">
                        @if ($post->categoryObject)
                            <a href="{{ route('web.blog.categoria', ['slug' => $post->categoryObject->slug]) }}"
                               class="inline-block rounded bg-red-50 px-2 py-0.5 text-xs font-semibold uppercase tracking-wide text-red-600 hover:bg-red-100">
                                {{ $post->categoryObject->title }}
                            </a>
                        @endif

                        <h1 class="mt-3 text-2xl font-bold leading-tight text-slate-900 sm:text-3xl">
                            {{ $post->title }}
                        </h1>

                        <div class="mt-3 flex flex-wrap items-center gap-4 text-sm text-slate-500">
                            <span class="flex items-center gap-1">
                                <i class="fa-regular fa-clock" aria-hidden="true"></i>
                                {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-eye" aria-hidden="true"></i> {{ $post->views }}
                            </span>
                        </div>

                        {{-- Compartilhamento (topo) --}}
                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            <div class="fb-share-button" data-href="{{ url()->current() }}" data-layout="button_count" data-size="large">
                                <a target="_blank" rel="noopener"
                                   href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;src=sdkpreparse"
                                   class="fb-xfbml-parse-ignore inline-flex items-center gap-2 rounded-md bg-blue-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-blue-700 transition">
                                    <i class="fa-brands fa-facebook" aria-hidden="true"></i> Compartilhar
                                </a>
                            </div>
                            <a target="_blank" rel="noopener"
                               href="https://web.whatsapp.com/send?text={{ url()->current() }}"
                               data-action="share/whatsapp/share"
                               class="inline-flex items-center gap-2 rounded-md bg-emerald-500 px-3 py-1.5 text-sm font-medium text-white hover:bg-emerald-600 transition">
                                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Compartilhar
                            </a>
                        </div>
                    </header>

                    {{-- Imagem de capa --}}
                    <div class="mb-6 overflow-hidden rounded-xl">
                        <a href="{{ $post->nocover() }}" class="gallery-popup block" data-lightbox-trigger>
                            <img src="{{ $post->cover() }}" alt="{{ $post->title }}" class="w-full object-cover">
                        </a>
                    </div>

                    {{-- Conteúdo --}}
                    <div class="prose prose-slate max-w-none text-base leading-relaxed text-slate-700">
                        {!! $post->content !!}
                        @if ($post->thumb_legenda)
                            <p class="text-sm text-slate-500">{{ $post->thumb_legenda }}</p>
                        @endif
                    </div>

                    {{-- Galeria de imagens adicionais --}}
                    @if ($post->images()->get()->count())
                        <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">
                            @foreach ($post->images()->get() as $image)
                                <a href="{{ $image->url_image }}"
                                   class="gallery-popup block overflow-hidden rounded-lg"
                                   data-lightbox-trigger>
                                    <img src="{{ $image->url_cropped }}" alt="{{ $post->title }}"
                                         class="h-32 w-full object-cover transition hover:opacity-90 sm:h-36">
                                </a>
                            @endforeach
                        </div>
                    @endif

                    {{-- Compartilhamento (rodapé do artigo) --}}
                    <div class="mt-8 border-t border-slate-200 pt-6">
                        <h5 class="mb-3 text-sm font-bold text-slate-800">Compartilhe este artigo:</h5>
                        <div class="flex flex-wrap items-center gap-2">
                            <div class="fb-share-button" data-href="{{ url()->current() }}" data-layout="button_count" data-size="large">
                                <a target="_blank" rel="noopener"
                                   href="https://www.facebook.com/sharer/sharer.php?u={{ url()->current() }}&amp;src=sdkpreparse"
                                   class="fb-xfbml-parse-ignore inline-flex items-center gap-2 rounded-md bg-blue-600 px-3 py-1.5 text-sm font-medium text-white hover:bg-blue-700 transition">
                                    <i class="fa-brands fa-facebook" aria-hidden="true"></i> Compartilhar
                                </a>
                            </div>
                            <a target="_blank" rel="noopener"
                               href="https://web.whatsapp.com/send?text={{ url()->current() }}"
                               data-action="share/whatsapp/share"
                               class="inline-flex items-center gap-2 rounded-md bg-emerald-500 px-3 py-1.5 text-sm font-medium text-white hover:bg-emerald-600 transition">
                                <i class="fa-brands fa-whatsapp" aria-hidden="true"></i> Compartilhar
                            </a>
                        </div>
                    </div>

                </article>

                {{-- Navegação entre posts --}}
                @if ((!empty($postprevious) && $postprevious->count() > 0) || (!empty($postnext) && $postnext->count() > 0))
                    <nav class="mt-8 grid grid-cols-1 gap-4 sm:grid-cols-2">
                        @if (!empty($postprevious) && $postprevious->count() > 0)
                            <a href="{{ route($postprevious->type == 'artigo' ? 'web.blog.artigo' : 'web.noticia', ['slug' => $postprevious->slug]) }}"
                               class="rounded-xl border border-slate-200 p-4 transition hover:border-red-300 hover:bg-red-50">
                                <span class="flex items-center gap-1 text-xs font-medium text-slate-500">
                                    <i class="fa-solid fa-angle-left" aria-hidden="true"></i> Anterior
                                </span>
                                <h3 class="mt-1 text-sm font-bold leading-snug text-slate-900 line-clamp-2">{{ $postprevious->title }}</h3>
                            </a>
                        @endif
                        @if (!empty($postnext) && $postnext->count() > 0)
                            <a href="{{ route($postnext->type == 'artigo' ? 'web.blog.artigo' : 'web.noticia', ['slug' => $postnext->slug]) }}"
                               class="rounded-xl border border-slate-200 p-4 text-right transition hover:border-red-300 hover:bg-red-50 sm:text-right">
                                <span class="flex items-center justify-end gap-1 text-xs font-medium text-slate-500">
                                    Próximo <i class="fa-solid fa-angle-right" aria-hidden="true"></i>
                                </span>
                                <h3 class="mt-1 text-sm font-bold leading-snug text-slate-900 line-clamp-2">{{ $postnext->title }}</h3>
                            </a>
                        @endif
                    </nav>
                @endif

                {{-- Box do autor --}}
                @if ($post->type == 'artigo' && $post->user)
                    <div class="mt-8 flex gap-4 rounded-xl border border-slate-200 p-5">
                        <img src="{{ $post->user->getUrlAvatarAttribute() }}" alt="{{ $post->user->name }}"
                             class="h-16 w-16 flex-shrink-0 rounded-full object-cover">
                        <div>
                            <h3 class="text-base font-bold text-slate-900">{{ $post->user->name }}</h3>
                            <div class="mt-1 text-sm leading-relaxed text-slate-600">
                                {!! $post->user->notasadicionais !!}
                            </div>
                            <ul class="mt-3 flex items-center gap-3">
                                @if ($post->user->facebook)
                                    <li>
                                        <a target="_blank" rel="noopener" href="{{ $post->user->facebook }}" title="Facebook"
                                           class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-blue-600 hover:text-white transition">
                                            <i class="fa-brands fa-facebook text-sm" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                @endif
                                @if ($post->user->twitter)
                                    <li>
                                        <a target="_blank" rel="noopener" href="{{ $post->user->twitter }}" title="Twitter"
                                           class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-sky-500 hover:text-white transition">
                                            <i class="fa-brands fa-twitter text-sm" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                @endif
                                @if ($post->user->instagram)
                                    <li>
                                        <a target="_blank" rel="noopener" href="{{ $post->user->instagram }}" title="Instagram"
                                           class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-pink-600 hover:text-white transition">
                                            <i class="fa-brands fa-instagram text-sm" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                @endif
                                @if ($post->user->linkedin)
                                    <li>
                                        <a target="_blank" rel="noopener" href="{{ $post->user->linkedin }}" title="LinkedIn"
                                           class="flex h-8 w-8 items-center justify-center rounded-full bg-slate-100 text-slate-600 hover:bg-blue-700 hover:text-white transition">
                                            <i class="fa-brands fa-linkedin text-sm" aria-hidden="true"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Comentários (desativado, mantido como no original) --}}
                {{--
                <div id="comments" class="comments-area block">
                  ...
                </div>
                --}}

                {{-- Formulário de comentários (desativado, mantido como no original) --}}
                {{--
                <div class="comments-form">
                  ...
                </div>
                --}}

            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4">
                @include('web.partials.post-sidebar')
            </aside>

        </div>
    </div>

    {{-- Banner de rodapé --}}
    @if (!empty($positionFooterPost) && $positionFooterPost->count() > 0)
        @foreach ($positionFooterPost as $f)
            <div class="mt-10 border-t border-slate-200 py-8 text-center">
                <div class="mx-auto max-w-7xl px-4">
                    <a href="{{ $f->link ?? '#' }}" target="_blank" rel="noopener" class="inline-block">
                        <img src="{{ $f->get728x90() }}" alt="{{ $f->title }}" class="mx-auto max-w-full">
                    </a>
                </div>
            </div>
        @endforeach
    @else
        <div class="mt-10 border-t border-slate-200 py-8 text-center">
            <div class="mx-auto max-w-7xl px-4">
                <x-ad slot="article_footer" />
            </div>
        </div>
    @endif

</section>

@endsection

@section('js')

@include('web.partials.lightbox-script')

<div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v18.0&appId=1787040554899561&autoLogAppEvents=1" nonce="1eBNUT9J"></script>
@endsection