@extends('web.master.master')

@section('content')

@php
    $url = urlencode(request()->fullUrl());
    $title = urlencode($empresa->alias_name);
@endphp

{{-- Breadcrumb --}}
<div class="border-b border-slate-200 bg-slate-50 py-4">
    <div class="mx-auto max-w-7xl px-4">
        <ul class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
            <li>
                <a href="{{ route('web.home') }}" class="hover:text-red-600 transition">Início</a>
            </li>
            <li class="flex items-center gap-2">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400" aria-hidden="true"></i>
                <a href="{{ route('web.guiaUbatuba') }}" class="hover:text-red-600 transition">Guia</a>
            </li>

            @if ($empresa->categoriaObject)
                <li class="flex items-center gap-2">
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400" aria-hidden="true"></i>
                    <a href="{{ route('web.guiaCategoria', $empresa->categoriaObject->slug) }}" class="hover:text-red-600 transition">
                        {{ $empresa->categoriaObject->title }}
                    </a>
                </li>
            @endif

            @if ($empresa->subcategoriaObject)
                <li class="flex items-center gap-2">
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400" aria-hidden="true"></i>
                    <a href="{{ route('web.guiaSubCategoria', $empresa->subcategoriaObject->slug) }}" class="hover:text-red-600 transition">
                        {{ $empresa->subcategoriaObject->title }}
                    </a>
                </li>
            @endif

            <li class="flex items-center gap-2 max-w-xs truncate">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400" aria-hidden="true"></i>
                <span class="text-slate-800 font-medium truncate">{{ $empresa->alias_name }}</span>
            </li>
        </ul>
    </div>
</div>

<section class="py-8">
    <div class="mx-auto max-w-7xl px-4">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-12">

            {{-- Sidebar --}}
            <aside class="order-2 lg:order-1 lg:col-span-4">

                <div class="rounded-xl border border-slate-200 bg-white p-5 text-center shadow-sm">
                    <img src="{{ $empresa->getlogo() }}" alt="{{ $empresa->alias_name }}" class="mx-auto max-h-40 object-contain">
                </div>

                @if ($empresa->email || $empresa->telefone || $empresa->whatsapp)
                    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                        <h3 class="mb-3 border-b border-slate-200 pb-2 text-base font-bold uppercase tracking-wide text-red-700">
                            Atendimento
                        </h3>
                        <div class="flex flex-col gap-2 text-sm text-slate-700">
                            @if ($empresa->email)
                                <p class="flex items-center gap-2">
                                    <i class="fa-solid fa-envelope text-slate-400" aria-hidden="true"></i>
                                    <a href="mailto:{{ $empresa->email }}" class="hover:text-red-600 break-all">{{ $empresa->email }}</a>
                                </p>
                            @endif
                            @if ($empresa->telefone)
                                <p class="flex items-center gap-2">
                                    <i class="fa-solid fa-phone text-slate-400" aria-hidden="true"></i>
                                    <a href="tel:{{ $empresa->telefone }}" class="hover:text-red-600">{{ $empresa->telefone }}</a>
                                </p>
                            @endif
                            @if ($empresa->whatsapp)
                                <p class="flex items-center gap-2">
                                    <i class="fa-brands fa-whatsapp text-slate-400" aria-hidden="true"></i>
                                    <a href="{{ \App\Helpers\WhatsApp::getNumZap($empresa->whatsapp, $empresa->alias_name) }}" target="_blank" rel="noopener" class="hover:text-red-600">
                                        {{ $empresa->whatsapp }}
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>
                @endif

                @php
                    $temRedeSocial = collect(['facebook', 'instagram', 'linkedin', 'twitter'])
                        ->contains(fn ($field) => !empty($empresa->$field));
                @endphp

                @if ($temRedeSocial)
                    <div class="mt-6 rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                        <div class="flex gap-3">
                            @foreach ([
                                'facebook'  => ['icon' => 'fa-brands fa-facebook', 'hover' => 'hover:bg-blue-600'],
                                'instagram' => ['icon' => 'fa-brands fa-instagram', 'hover' => 'hover:bg-pink-600'],
                                'linkedin'  => ['icon' => 'fa-brands fa-linkedin', 'hover' => 'hover:bg-blue-700'],
                                'twitter'   => ['icon' => 'fa-brands fa-twitter', 'hover' => 'hover:bg-sky-500'],
                            ] as $field => $conf)
                                @if ($empresa->$field)
                                    <a href="{{ $empresa->$field }}" target="_blank" rel="noopener"
                                       class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-100 text-slate-600 transition {{ $conf['hover'] }} hover:text-white">
                                        <i class="{{ $conf['icon'] }}" aria-hidden="true"></i>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                @if ($empresa->maps)
                    <div class="mt-6 overflow-hidden rounded-xl border border-slate-200 shadow-sm">
                        {!! $empresa->maps !!}
                    </div>
                @endif

            </aside>

            {{-- Conteúdo principal --}}
            <div class="order-1 lg:order-2 lg:col-span-8">
                <article>

                    <header class="mb-6">
                        @if ($empresa->categoriaObject)
                            <a href="{{ route('web.guiaSubCategoria', ['slug' => $empresa->categoriaObject->slug]) }}"
                               class="inline-block rounded bg-red-50 px-2 py-0.5 text-xs font-semibold uppercase tracking-wide text-red-600 hover:bg-red-100">
                                {{ $empresa->categoriaObject->title }}
                            </a>
                        @endif

                        <h1 class="mt-3 text-2xl font-bold leading-tight text-slate-900 sm:text-3xl">
                            {{ $empresa->alias_name }}
                        </h1>

                        <div class="mt-3 flex items-center gap-1 text-sm text-slate-500">
                            <i class="fa-solid fa-eye" aria-hidden="true"></i> {{ $empresa->views }}
                        </div>
                    </header>

                    <div class="prose prose-slate max-w-none leading-relaxed text-slate-700">
                        {!! $empresa->content !!}
                    </div>

                    @if ($empresa->metatags)
                        <div class="mt-4 flex flex-wrap gap-2">
                            @foreach ($empresa->metatags_array as $tag)
                                <span class="rounded bg-slate-100 px-2 py-1 text-xs text-slate-600">
                                    #{{ trim($tag) }}
                                </span>
                            @endforeach
                        </div>
                    @endif

                    {{-- Compartilhar --}}
                    <div class="mt-8 border-t border-slate-200 pt-6">
                        <h3 class="mb-4 text-lg font-semibold text-slate-900">
                            Compartilhe
                        </h3>
                        <div class="flex flex-wrap gap-3">

                            {{-- Facebook --}}
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                               target="_blank" rel="noopener"
                               class="flex h-10 w-10 items-center justify-center rounded-full bg-[#1877F2] text-white transition hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M22 12a10 10 0 10-11.63 9.87v-6.99h-2.8V12h2.8V9.8c0-2.76 1.64-4.3 4.15-4.3 1.2 0 2.45.21 2.45.21v2.7h-1.38c-1.36 0-1.78.84-1.78 1.7V12h3.03l-.48 2.88h-2.55v6.99A10 10 0 0022 12z"/>
                                </svg>
                            </a>

                            {{-- X --}}
                            <a href="https://twitter.com/intent/tweet?text={{ $title }}&url={{ $url }}"
                               target="_blank" rel="noopener"
                               class="flex h-10 w-10 items-center justify-center rounded-full bg-black text-white transition hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M18.244 2H21l-6.563 7.502L22 22h-6.828l-5.341-7.03L3.463 22H1l7.02-8.02L2 2h6.91l4.825 6.37L18.244 2z"/>
                                </svg>
                            </a>

                            {{-- WhatsApp --}}
                            <a href="#" data-share="whatsapp" target="_blank" rel="noopener"
                               class="flex h-10 w-10 items-center justify-center rounded-full bg-[#25D366] text-white transition hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M20.52 3.48A11.93 11.93 0 0012.04 0C5.43 0 .1 5.33.1 11.94c0 2.1.55 4.15 1.6 5.96L0 24l6.27-1.64a11.92 11.92 0 005.77 1.47h.01c6.61 0 11.94-5.33 11.94-11.94 0-3.19-1.24-6.19-3.47-8.41zM12.05 21.8h-.01a9.87 9.87 0 01-5.02-1.37l-.36-.21-3.72.97.99-3.63-.23-.37a9.87 9.87 0 01-1.51-5.24c0-5.46 4.45-9.9 9.91-9.9 2.65 0 5.14 1.03 7.01 2.91a9.84 9.84 0 012.89 7c0 5.46-4.45 9.9-9.91 9.9zm5.44-7.37c-.3-.15-1.76-.87-2.03-.97-.27-.1-.46-.15-.65.15-.2.3-.75.97-.92 1.17-.17.2-.34.22-.64.07-.3-.15-1.26-.46-2.4-1.46-.88-.79-1.48-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.34.45-.5.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.65-1.57-.9-2.15-.24-.57-.49-.5-.65-.51h-.55c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.06 2.87 1.21 3.07.15.2 2.08 3.17 5.05 4.45.7.3 1.25.48 1.68.62.7.22 1.33.19 1.83.12.56-.08 1.76-.72 2.01-1.41.25-.7.25-1.3.17-1.41-.07-.1-.27-.17-.57-.32z"/>
                                </svg>
                            </a>

                            {{-- LinkedIn --}}
                            <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $url }}"
                               target="_blank" rel="noopener"
                               class="flex h-10 w-10 items-center justify-center rounded-full bg-[#0A66C2] text-white transition hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M4.98 3.5C4.98 4.88 3.86 6 2.49 6S0 4.88 0 3.5 1.12 1 2.49 1s2.49 1.12 2.49 2.5zM0 8h5v16H0V8zm7.5 0h4.78v2.16h.07c.67-1.27 2.3-2.6 4.73-2.6 5.06 0 6 3.33 6 7.66V24h-5v-7.84c0-1.87-.03-4.28-2.61-4.28-2.61 0-3.01 2.04-3.01 4.15V24h-5V8z"/>
                                </svg>
                            </a>

                            {{-- Telegram --}}
                            <a href="https://t.me/share/url?url={{ $url }}&text={{ $title }}"
                               target="_blank" rel="noopener"
                               class="flex h-10 w-10 items-center justify-center rounded-full bg-[#229ED9] text-white transition hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M9.993 15.674l-.4 4.326c.573 0 .822-.246 1.123-.54l2.694-2.577 5.586 4.09c1.024.563 1.75.267 2.004-.95l3.63-17.037c.337-1.56-.563-2.17-1.558-1.8L1.357 9.63c-1.516.592-1.495 1.44-.258 1.823l5.66 1.77 13.148-8.29c.62-.41 1.184-.183.72.227"/>
                                </svg>
                            </a>

                            {{-- Email --}}
                            <a href="mailto:?subject={{ $title }}&body={{ $url }}"
                               class="flex h-10 w-10 items-center justify-center rounded-full bg-slate-600 text-white transition hover:scale-110">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 fill-current" viewBox="0 0 24 24">
                                    <path d="M12 13.065L.015 4.5A2 2 0 012 3h20a2 2 0 011.985 1.5L12 13.065zM0 6.697V19a2 2 0 002 2h20a2 2 0 002-2V6.697l-12 8.25L0 6.697z"/>
                                </svg>
                            </a>

                        </div>
                    </div>

                    {{-- Galeria de imagens --}}
                    @if ($empresa->images->where('cover', false)->isNotEmpty())
                        <div class="mt-6 grid grid-cols-2 gap-3 sm:grid-cols-3">
                            @foreach ($empresa->images->where('cover', false) as $image)
                                <a href="{{ $image->url_image }}" class="glightbox block overflow-hidden rounded-lg" data-gallery="empresa">
                                    <img src="{{ $image->url_cropped }}" alt="{{ $empresa->alias_name }}"
                                         class="h-32 w-full object-cover transition hover:opacity-90">
                                </a>
                            @endforeach
                        </div>
                    @endif

                </article>

                {{-- Formulário de contato --}}
                @if ($empresa->email)
                    <div class="mt-8">
                        <livewire:web.email.contact-company-form :empresa="$empresa" />
                    </div>
                @endif

            </div>

        </div>

        {{-- Veja também --}}
        @if ($empresas->isNotEmpty() && !$empresa->client)
            <div class="mt-10 border-t border-slate-200 pt-8">
                <h3 class="mb-4 text-lg font-semibold text-slate-900">Veja também</h3>

                <div class="grid grid-cols-2 gap-4 md:grid-cols-4">
                    @foreach ($empresas as $item)
                        <a href="{{ route('web.guiaEmpresa', $item->slug) }}"
                           class="block rounded-xl border border-slate-200 bg-white p-4 text-center transition hover:scale-105 hover:shadow-md">
                            <img src="{{ $item->getlogo() }}" alt="{{ $item->alias_name }}"
                                 class="mx-auto h-16 max-w-[120px] object-contain">
                            <p class="mt-2 text-sm font-medium text-slate-700">{{ $item->alias_name }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</section>

@endsection

@section('js')
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const lightbox = GLightbox({ selector: '.glightbox' });

        const whatsappLink = document.querySelector('[data-share="whatsapp"]');

        if (whatsappLink) {
            whatsappLink.addEventListener('click', function (event) {
                event.preventDefault();

                const url = encodeURIComponent(window.location.href);
                const text = encodeURIComponent(document.title);
                const message = text + ' ' + url;

                const isMobile = /Android|iPhone|iPad|iPod|Opera Mini|IEMobile|WPDesktop/i.test(navigator.userAgent);

                const whatsappUrl = isMobile
                    ? `https://api.whatsapp.com/send?text=${message}`
                    : `https://web.whatsapp.com/send?text=${message}`;

                window.open(whatsappUrl, '_blank');
            });
        }
    });
</script>
@endsection