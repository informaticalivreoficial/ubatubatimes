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
                <span class="text-slate-800 font-medium">{{ $type == 'noticia' ? 'Notícias' : 'Blog' }}</span>
            </li>
        </ul>
    </div>
</div>

@if ($posts->count() > 0)
    <section class="py-8">
        <div class="mx-auto max-w-7xl px-4">

            <div id="scrolling-pagination"
                 class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3"
                 data-next-url="{{ $posts->nextPageUrl() }}">
                @include('web.partials.posts-grid', ['posts' => $posts])
            </div>

            {{-- Sentinela invisível: quando aparecer na tela, carrega a próxima página --}}
            <div id="infinite-sentinel" class="h-1"></div>

            {{-- Indicador de carregamento --}}
            <div id="infinite-loading" class="mt-8 hidden items-center justify-center gap-2 text-sm text-slate-500">
                <i class="fa-solid fa-spinner fa-spin" aria-hidden="true"></i>
                Carregando mais conteúdo...
            </div>

            {{-- Aviso de fim de lista --}}
            <div id="infinite-end" class="mt-8 hidden items-center justify-center text-sm text-slate-400">
                Não há mais conteúdo para carregar.
            </div>

        </div>

        {{-- Banner de rodapé --}}
        @if (!empty($positionFooterBlog) && $positionFooterBlog->count() > 0)
            @foreach ($positionFooterBlog as $f)
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
                    @if ($type == 'noticia')
                        <x-ad slot="noticias_sidebar" />
                    @else
                        <x-ad slot="articles_footer" />
                    @endif
                </div>
            </div>
        @endif
    </section>
@endif

@endsection

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var grid      = document.getElementById('scrolling-pagination');
        var sentinel  = document.getElementById('infinite-sentinel');
        var loading   = document.getElementById('infinite-loading');
        var endNotice = document.getElementById('infinite-end');

        var nextUrl    = grid.dataset.nextUrl || null;
        var isFetching = false;

        if (!nextUrl) {
            endNotice.classList.remove('hidden');
            endNotice.classList.add('flex');
            return;
        }

        var observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting && nextUrl && !isFetching) {
                    loadNextPage();
                }
            });
        }, { rootMargin: '400px' });

        observer.observe(sentinel);

        function loadNextPage() {
            isFetching = true;
            loading.classList.remove('hidden');
            loading.classList.add('flex');

            fetch(nextUrl, {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
                .then(function (response) { return response.json(); })
                .then(function (data) {
                    grid.insertAdjacentHTML('beforeend', data.html);
                    nextUrl = data.next_page_url;

                    loading.classList.add('hidden');
                    loading.classList.remove('flex');
                    isFetching = false;

                    if (!nextUrl) {
                        observer.disconnect();
                        endNotice.classList.remove('hidden');
                        endNotice.classList.add('flex');
                    }
                })
                .catch(function () {
                    loading.classList.add('hidden');
                    loading.classList.remove('flex');
                    isFetching = false;
                });
        }
    });
</script>
@endsection