@extends('web.master.master')

@section('content')
<section class="py-6 md:py-10">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">

            {{-- Coluna principal --}}
            <div class="lg:col-span-8">

                @if ($noticiasUbatuba && $noticiasUbatuba->count() > 0)
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                        @foreach ($noticiasUbatuba as $noticiau)
                            <article class="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                                <a href="{{ route('web.noticia', ['slug' => $noticiau->slug]) }}" class="block overflow-hidden">
                                    <img src="{{ $noticiau->cover() }}" alt="{{ $noticiau->title }}"
                                         class="h-48 w-full object-cover transition duration-300 group-hover:scale-105 sm:h-44 lg:h-52">
                                </a>
                                <div class="p-4">
                                    <a href="#" class="inline-block rounded bg-red-50 px-2 py-0.5 text-xs font-semibold uppercase tracking-wide text-red-600 hover:bg-red-100">
                                        Ubatuba
                                    </a>
                                    <h2 class="mt-2 text-base font-bold leading-snug text-slate-900 sm:text-lg">
                                        <a href="{{ route('web.noticia', ['slug' => $noticiau->slug]) }}" class="hover:text-red-600">
                                            {{ $noticiau->title }}
                                        </a>
                                    </h2>
                                    <div class="mt-3 flex items-center gap-4 text-xs text-slate-500">
                                        <span class="flex items-center gap-1">
                                            <i class="fa fa-eye" aria-hidden="true"></i> {{ $noticiau->views }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            {{ \Carbon\Carbon::parse($noticiau->created_at)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

                @if (($artigosDestaque && $artigosDestaque->count() > 0) || $estradas)
                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                        @if ($artigosDestaque && $artigosDestaque->count() > 0)
                            @foreach ($artigosDestaque as $artD)
                                <article class="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                                    <a href="{{ route('web.blog.artigo', ['slug' => $artD->slug]) }}" class="block overflow-hidden">
                                        <img src="{{ $artD->cover() }}" alt="{{ $artD->title }}"
                                             class="h-48 w-full object-cover transition duration-300 group-hover:scale-105 sm:h-44 lg:h-52">
                                    </a>
                                    <div class="p-4">
                                        @if ($artD->categoryObject)
                                            <a href="#" class="inline-block rounded bg-red-50 px-2 py-0.5 text-xs font-semibold uppercase tracking-wide text-red-600 hover:bg-red-100">
                                                {{ $artD->categoryObject->title }}
                                            </a>
                                        @endif
                                        <h2 class="mt-2 text-base font-bold leading-snug text-slate-900 sm:text-lg">
                                            <a href="{{ route('web.blog.artigo', ['slug' => $artD->slug]) }}" class="hover:text-red-600">
                                                {{ $artD->title }}
                                            </a>
                                        </h2>
                                        <div class="mt-3 flex items-center gap-4 text-xs text-slate-500">
                                            <span class="flex items-center gap-1">
                                                <i class="fa fa-eye" aria-hidden="true"></i> {{ $artD->views }}
                                            </span>
                                            <span class="flex items-center gap-1">
                                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                {{ \Carbon\Carbon::parse($artD->created_at)->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        @endif

                        @if ($estradas)
                            <article class="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                                <a href="{{ route('web.noticia', ['slug' => $estradas->slug]) }}" class="block overflow-hidden">
                                    <img src="{{ $estradas->cover() }}" alt="{{ $estradas->title }}"
                                         class="h-48 w-full object-cover transition duration-300 group-hover:scale-105 sm:h-44 lg:h-52">
                                </a>
                                <div class="p-4">
                                    @if ($estradas->categoryObject)
                                        <a href="#" class="inline-block rounded bg-red-50 px-2 py-0.5 text-xs font-semibold uppercase tracking-wide text-red-600 hover:bg-red-100">
                                            {{ $estradas->categoryObject->title }}
                                        </a>
                                    @endif
                                    <h2 class="mt-2 text-base font-bold leading-snug text-slate-900 sm:text-lg">
                                        <a href="{{ route('web.noticia', ['slug' => $estradas->slug]) }}" class="hover:text-red-600">
                                            {{ $estradas->title }}
                                        </a>
                                    </h2>
                                    <div class="mt-3 flex items-center gap-4 text-xs text-slate-500">
                                        <span class="flex items-center gap-1">
                                            <i class="fa fa-eye" aria-hidden="true"></i> {{ $estradas->views }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            {{ \Carbon\Carbon::parse($estradas->created_at)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @endif
                    </div>
                @endif

                @if ($noticiasUbatuba1 && $noticiasUbatuba1->count() > 0)
                    <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2">
                        @foreach ($noticiasUbatuba1 as $noticiau1)
                            <article class="group overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
                                <a href="{{ route('web.noticia', ['slug' => $noticiau1->slug]) }}" class="block overflow-hidden">
                                    <img src="{{ $noticiau1->cover() }}" alt="{{ $noticiau1->title }}"
                                         class="h-48 w-full object-cover transition duration-300 group-hover:scale-105 sm:h-44 lg:h-52">
                                </a>
                                <div class="p-4">
                                    <a href="#" class="inline-block rounded bg-red-50 px-2 py-0.5 text-xs font-semibold uppercase tracking-wide text-red-600 hover:bg-red-100">
                                        Ubatuba
                                    </a>
                                    <h2 class="mt-2 text-base font-bold leading-snug text-slate-900 sm:text-lg">
                                        <a href="{{ route('web.noticia', ['slug' => $noticiau1->slug]) }}" class="hover:text-red-600">
                                            {{ $noticiau1->title }}
                                        </a>
                                    </h2>
                                    <div class="mt-3 flex items-center gap-4 text-xs text-slate-500">
                                        <span class="flex items-center gap-1">
                                            <i class="fa fa-eye" aria-hidden="true"></i> {{ $noticiau1->views }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            <i class="fa fa-clock-o" aria-hidden="true"></i>
                                            {{ \Carbon\Carbon::parse($noticiau1->created_at)->format('d/m/Y') }}
                                        </span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                @endif

            </div>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4">
                <div class="flex flex-col gap-6 lg:sticky lg:top-20">
                    <div class="rounded-xl bg-slate-100 py-8 text-center">
                        <x-ad slot="home_sidebar" />
                    </div>
                    <div class="rounded-xl bg-slate-100 py-8 text-center">
                        <x-ad slot="home_sidebar_1" />
                    </div>
                </div>
            </aside>

        </div>
    </div>
</section> 
    

    <section class="py-8">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-1 gap-8 lg:grid-cols-3">

            @if ($noticiasCaragua && $noticiasCaragua->count() > 0)
                <div>
                    <h3 class="mb-4 border-b-2 border-blue-700 pb-2 text-lg font-bold uppercase tracking-wide text-blue-800">
                        Caraguatatuba
                    </h3>

                    {{-- Primeira notícia em destaque --}}
                    <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        <a href="{{ route('web.noticia', ['slug' => $noticiasCaragua[0]->slug]) }}" class="block">
                            <img src="{{ $noticiasCaragua[0]->cover() }}" alt="{{ $noticiasCaragua[0]->title }}"
                                 class="h-44 w-full object-cover sm:h-48">
                        </a>
                        <div class="p-4">
                            <h2 class="text-base font-bold leading-snug text-slate-900">
                                <a href="{{ route('web.noticia', ['slug' => $noticiasCaragua[0]->slug]) }}" class="hover:text-blue-700">
                                    {{ $noticiasCaragua[0]->title }}
                                </a>
                            </h2>
                            <div class="mt-2 flex items-center gap-4 text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ $noticiasCaragua[0]->views }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    {{ \Carbon\Carbon::parse($noticiasCaragua[0]->created_at)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </article>

                    {{-- Demais notícias em lista --}}
                    @if ($noticiasCaragua->count() > 1)
                        <ul class="mt-4 flex flex-col gap-4">
                            @foreach ($noticiasCaragua->skip(1) as $noticia)
                                <li>
                                    <div class="flex gap-3">
                                        <a href="{{ route('web.noticia', ['slug' => $noticia->slug]) }}"
                                           class="block h-20 w-28 flex-shrink-0 overflow-hidden rounded-lg">
                                            <img src="{{ $noticia->cover() }}" alt="{{ $noticia->title }}"
                                                 class="h-full w-full object-cover">
                                        </a>
                                        <div class="min-w-0">
                                            <h2 class="text-sm font-semibold leading-snug text-slate-900">
                                                <a href="{{ route('web.noticia', ['slug' => $noticia->slug]) }}" class="hover:text-blue-700">
                                                    {{ $noticia->title }}
                                                </a>
                                            </h2>
                                            <div class="mt-1 flex items-center gap-3 text-xs text-slate-500">
                                                <span class="flex items-center gap-1">
                                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ $noticia->views }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                    {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

            @if ($noticiasSaoSebastiao && $noticiasSaoSebastiao->isNotEmpty())
                <div>
                    <h3 class="mb-4 border-b-2 border-cyan-600 pb-2 text-lg font-bold uppercase tracking-wide text-cyan-700">
                        São Sebastião
                    </h3>

                    {{-- Primeira notícia em destaque --}}
                    <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        <a href="{{ route('web.noticia', ['slug' => $noticiasSaoSebastiao[0]->slug]) }}" class="block">
                            <img src="{{ $noticiasSaoSebastiao[0]->cover() }}" alt="{{ $noticiasSaoSebastiao[0]->title }}"
                                 class="h-44 w-full object-cover sm:h-48">
                        </a>
                        <div class="p-4">
                            <h2 class="text-base font-bold leading-snug text-slate-900">
                                <a href="{{ route('web.noticia', ['slug' => $noticiasSaoSebastiao[0]->slug]) }}" class="hover:text-cyan-700">
                                    {{ $noticiasSaoSebastiao[0]->title }}
                                </a>
                            </h2>
                            <div class="mt-2 flex items-center gap-4 text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ $noticiasSaoSebastiao[0]->views }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    {{ \Carbon\Carbon::parse($noticiasSaoSebastiao[0]->created_at)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </article>

                    {{-- Demais notícias em lista --}}
                    @if ($noticiasSaoSebastiao->count() > 1)
                        <ul class="mt-4 flex flex-col gap-4">
                            @foreach ($noticiasSaoSebastiao->skip(1) as $noticia)
                                <li>
                                    <div class="flex gap-3">
                                        <a href="{{ route('web.noticia', ['slug' => $noticia->slug]) }}"
                                           class="block h-20 w-28 flex-shrink-0 overflow-hidden rounded-lg">
                                            <img src="{{ $noticia->cover() }}" alt="{{ $noticia->title }}"
                                                 class="h-full w-full object-cover">
                                        </a>
                                        <div class="min-w-0">
                                            <h2 class="text-sm font-semibold leading-snug text-slate-900">
                                                <a href="{{ route('web.noticia', ['slug' => $noticia->slug]) }}" class="hover:text-cyan-700">
                                                    {{ $noticia->title }}
                                                </a>
                                            </h2>
                                            <div class="mt-1 flex items-center gap-3 text-xs text-slate-500">
                                                <span class="flex items-center gap-1">
                                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ $noticia->views }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                    {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

            @if ($noticiasIlhabela && $noticiasIlhabela->count() > 0)
                <div>
                    <h3 class="mb-4 border-b-2 border-violet-600 pb-2 text-lg font-bold uppercase tracking-wide text-violet-700">
                        Ilhabela
                    </h3>

                    {{-- Primeira notícia em destaque --}}
                    <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                        <a href="{{ route('web.noticia', ['slug' => $noticiasIlhabela[0]->slug]) }}" class="block">
                            <img src="{{ $noticiasIlhabela[0]->cover() }}" alt="{{ $noticiasIlhabela[0]->title }}"
                                 class="h-44 w-full object-cover sm:h-48">
                        </a>
                        <div class="p-4">
                            <h2 class="text-base font-bold leading-snug text-slate-900">
                                <a href="{{ route('web.noticia', ['slug' => $noticiasIlhabela[0]->slug]) }}" class="hover:text-violet-700">
                                    {{ $noticiasIlhabela[0]->title }}
                                </a>
                            </h2>
                            <div class="mt-2 flex items-center gap-4 text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ $noticiasIlhabela[0]->views }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    {{ \Carbon\Carbon::parse($noticiasIlhabela[0]->created_at)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </article>

                    {{-- Demais notícias em lista --}}
                    @if ($noticiasIlhabela->count() > 1)
                        <ul class="mt-4 flex flex-col gap-4">
                            @foreach ($noticiasIlhabela->skip(1) as $noticia)
                                <li>
                                    <div class="flex gap-3">
                                        <a href="{{ route('web.noticia', ['slug' => $noticia->slug]) }}"
                                           class="block h-20 w-28 flex-shrink-0 overflow-hidden rounded-lg">
                                            <img src="{{ $noticia->cover() }}" alt="{{ $noticia->title }}"
                                                 class="h-full w-full object-cover">
                                        </a>
                                        <div class="min-w-0">
                                            <h2 class="text-sm font-semibold leading-snug text-slate-900">
                                                <a href="{{ route('web.noticia', ['slug' => $noticia->slug]) }}" class="hover:text-violet-700">
                                                    {{ $noticia->title }}
                                                </a>
                                            </h2>
                                            <div class="mt-1 flex items-center gap-3 text-xs text-slate-500">
                                                <span class="flex items-center gap-1">
                                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ $noticia->views }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                    {{ \Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            @endif

        </div>
    </div>
</section>

@if ($artigos && $artigos->isNotEmpty())
    <section class="py-8">
        <div class="mx-auto max-w-7xl px-4">

            <div class="mb-4 flex items-center justify-between">
                <h3 class="border-b-2 border-red-600 pb-2 text-lg font-bold uppercase tracking-wide text-red-700">
                    Blog
                </h3>

                {{-- Setas de navegação (única forma de navegar, já que o arrastar foi desativado) --}}
                <div class="flex gap-2">
                    <button type="button"
                            onclick="document.getElementById('blog-scroll').scrollBy({left: -320, behavior: 'smooth'})"
                            aria-label="Artigos anteriores"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition hover:border-red-500 hover:text-red-600">
                        <i class="fa fa-chevron-left text-sm" aria-hidden="true"></i>
                    </button>
                    <button type="button"
                            onclick="document.getElementById('blog-scroll').scrollBy({left: 320, behavior: 'smooth'})"
                            aria-label="Próximos artigos"
                            class="flex h-9 w-9 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition hover:border-red-500 hover:text-red-600">
                        <i class="fa fa-chevron-right text-sm" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            {{-- Trilho (sem arrastar/swipe — navegação só pelas setas) --}}
            <div id="blog-scroll"
                 class="flex snap-x snap-mandatory gap-4 overflow-x-hidden scroll-smooth pb-2">
                @foreach ($artigos as $artigo)
                    <article class="w-[260px] flex-shrink-0 snap-start overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm sm:w-[280px]">
                        <a href="{{ route('web.blog.artigo', ['slug' => $artigo->slug]) }}" class="block">
                            <img src="{{ $artigo->cover() }}" alt="{{ $artigo->title }}"
                                 class="h-40 w-full object-cover">
                        </a>
                        <div class="p-4">
                            @if ($artigo->categoryObject)
                                <a href="#" class="inline-block rounded bg-red-50 px-2 py-0.5 text-xs font-semibold uppercase tracking-wide text-red-600 hover:bg-red-100">
                                    {{ $artigo->categoryObject->title }}
                                </a>
                            @endif
                            <h2 class="mt-2 text-sm font-bold leading-snug text-slate-900">
                                <a href="{{ route('web.blog.artigo', ['slug' => $artigo->slug]) }}" class="hover:text-red-600">
                                    {{ $artigo->title }}
                                </a>
                            </h2>
                            <div class="mt-3 flex items-center gap-4 text-xs text-slate-500">
                                <span class="flex items-center gap-1">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ $artigo->views }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    {{ \Carbon\Carbon::parse($artigo->created_at)->format('d/m/Y') }}
                                </span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

        </div>
    </section>
@endif  
        
<div class="utf_ad_content_area text-center utf_banner_area no-padding">
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <x-ad slot="home_center" /> 
            </div>
        </div>
    </div>
</div>  
  
@if ($praiasDeUbatuba && $praiasDeUbatuba->isNotEmpty())
    <section class="py-8">
        <div class="mx-auto max-w-7xl px-4">
            <div class="grid grid-cols-1 gap-8 lg:grid-cols-12">

                {{-- Praias de Ubatuba --}}
                <div class="lg:col-span-8">
                    <h3 class="mb-4 border-b-2 border-blue-600 pb-2 text-lg font-bold uppercase tracking-wide text-blue-700">
                        Praias de Ubatuba
                    </h3>

                    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                        {{-- Primeira praia em destaque --}}
                        <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                            <a href="{{ route('web.blog.artigo', ['slug' => $praiasDeUbatuba[0]->slug]) }}" class="block">
                                <img src="{{ $praiasDeUbatuba[0]->cover() }}" alt="{{ $praiasDeUbatuba[0]->title }}"
                                     class="h-48 w-full object-cover">
                            </a>
                            <div class="p-4">
                                <span class="inline-flex items-center gap-1 rounded bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-700">
                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ $praiasDeUbatuba[0]->views }}
                                </span>
                                <h2 class="mt-2 text-base font-bold leading-snug text-slate-900">
                                    <a href="{{ route('web.blog.artigo', ['slug' => $praiasDeUbatuba[0]->slug]) }}" class="hover:text-blue-700">
                                        {{ $praiasDeUbatuba[0]->title }}
                                    </a>
                                </h2>
                                <div class="mt-2 flex items-center gap-4 text-xs text-slate-500">
                                    @if ($praiasDeUbatuba[0]->user)
                                        <span class="flex items-center gap-1">
                                            <i class="fa fa-user" aria-hidden="true"></i> {{ $praiasDeUbatuba[0]->user->name }}
                                        </span>
                                    @endif
                                    <span class="flex items-center gap-1">
                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                        {{ \Carbon\Carbon::parse($praiasDeUbatuba[0]->created_at)->format('d/m/Y') }}
                                    </span>
                                </div>
                                <p class="mt-3 text-sm leading-relaxed text-slate-600">
                                    {!! \App\Helpers\Renato::Words($praiasDeUbatuba[0]->content, 25) !!}
                                </p>
                            </div>
                        </article>

                        {{-- Demais praias em lista --}}
                        @if ($praiasDeUbatuba->count() > 1)
                            <ul class="flex flex-col gap-4">
                                @foreach ($praiasDeUbatuba->skip(1) as $praia)
                                    <li>
                                        <div class="flex gap-3">
                                            <a href="{{ route('web.blog.artigo', ['slug' => $praia->slug]) }}"
                                               class="block h-20 w-28 flex-shrink-0 overflow-hidden rounded-lg">
                                                <img src="{{ $praia->cover() }}" alt="{{ $praia->title }}"
                                                     class="h-full w-full object-cover">
                                            </a>
                                            <div class="min-w-0">
                                                <h2 class="text-sm font-semibold leading-snug text-slate-900">
                                                    <a href="{{ route('web.blog.artigo', ['slug' => $praia->slug]) }}" class="hover:text-blue-700">
                                                        {{ $praia->title }}
                                                    </a>
                                                </h2>
                                                <div class="mt-1 flex items-center gap-3 text-xs text-slate-500">
                                                    <span class="flex items-center gap-1">
                                                        <i class="fa fa-eye" aria-hidden="true"></i> {{ $praia->views }}
                                                    </span>
                                                    <span class="flex items-center gap-1">
                                                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                        {{ \Carbon\Carbon::parse($praia->created_at)->format('d/m/Y') }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                </div>

                {{-- Sidebar Gastronomia --}}
                @if ($gastronomiaDeUbatuba && $gastronomiaDeUbatuba->isNotEmpty())
                    <aside class="lg:col-span-4">
                        <h3 class="mb-4 border-b-2 border-slate-300 pb-2 text-lg font-bold uppercase tracking-wide text-slate-700">
                            Gastronomia
                        </h3>
                        <ul class="flex flex-col gap-4">
                            @foreach ($gastronomiaDeUbatuba as $receita)
                                <li>
                                    <div class="flex gap-3">
                                        <a href="{{ route('web.blog.artigo', ['slug' => $receita->slug]) }}"
                                           class="block h-20 w-28 flex-shrink-0 overflow-hidden rounded-lg">
                                            <img src="{{ $receita->cover() }}" alt="{{ $receita->title }}"
                                                 class="h-full w-full object-cover">
                                        </a>
                                        <div class="min-w-0">
                                            <h2 class="text-sm font-semibold leading-snug text-slate-900">
                                                <a href="{{ route('web.blog.artigo', ['slug' => $receita->slug]) }}" class="hover:text-slate-700">
                                                    {{ $receita->title }}
                                                </a>
                                            </h2>
                                            <div class="mt-1 flex items-center gap-3 text-xs text-slate-500">
                                                <span class="flex items-center gap-1">
                                                    <i class="fa fa-eye" aria-hidden="true"></i> {{ $receita->views }}
                                                </span>
                                                <span class="flex items-center gap-1">
                                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                                    {{ \Carbon\Carbon::parse($receita->created_at)->format('d/m/Y') }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </aside>
                @endif

            </div>
        </div>
    </section>
@endif

<div class="utf_ad_content_area text-center utf_banner_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <x-ad slot="home_footer" />
            </div>
        </div>
    </div>
</div>  
  
@endsection

@section('css')
<style>
    .img_person{
        min-height: 250px !important;
        max-height: 250px !important;
    }
    .img_person_blog{
        min-height: 170px !important;
        max-height: 170px !important;
    }
    .img_person_gastronomia{
        min-height: 75px !important;
        max-height: 75px !important;
        min-width: 100px !important;
    }
</style>
@endsection

@section('js')

@endsection