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
                <span class="text-slate-800 font-medium">Guia Comercial</span>
            </li>
        </ul>
    </div>
</div>

<section class="bg-slate-50 py-10">
    <div class="mx-auto max-w-7xl px-4">

        <div class="grid grid-cols-1 gap-6 md:grid-cols-2 lg:grid-cols-3">

            @foreach ($catEmpresas as $categoria)

                @if ($categoria->companies->isNotEmpty())

                    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:shadow-md">

                        {{-- Título --}}
                        <h3 class="mb-4 border-b border-slate-200 pb-2 text-lg font-semibold text-slate-800">
                            {{ $categoria->title }}
                        </h3>

                        {{-- Lista --}}
                        <ul class="flex flex-col gap-4">

                            @foreach ($categoria->companies->take(6) as $empresa)

                                <li class="flex items-start gap-4">

                                    {{-- Imagem --}}
                                    <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}" class="flex-shrink-0">
                                        <img
                                            src="{{ $empresa->getlogo() }}"
                                            alt="{{ $empresa->alias_name }}"
                                            class="h-20 w-20 rounded-lg border border-slate-200 object-contain"
                                        >
                                    </a>

                                    {{-- Conteúdo --}}
                                    <div class="min-w-0 flex-1">
                                        <h2 class="text-sm font-semibold leading-tight text-red-700">
                                            <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}" class="hover:text-red-800">
                                                {{ $empresa->alias_name }}
                                            </a>
                                        </h2>

                                        <p class="mt-1 text-xs leading-snug text-slate-600">
                                            {!! Words($empresa->content, 10) !!}
                                        </p>

                                        @if ($empresa->categoriaObject)
                                            <a
                                                href="{{ route('web.guiaSubCategoria', $empresa->categoriaObject->slug) }}"
                                                class="mt-1 inline-block text-xs font-semibold text-slate-500 hover:text-slate-700"
                                            >
                                                {{ $empresa->categoriaObject->title }}
                                            </a>
                                        @endif
                                    </div>

                                </li>

                            @endforeach

                        </ul>

                        {{-- Botão --}}
                        <div class="mt-5">
                            <a
                                href="{{ route('web.guiaCategoria', $categoria->slug) }}"
                                class="inline-flex items-center gap-1 text-sm font-medium text-blue-600 hover:underline"
                            >
                                Ver tudo <i class="fa-solid fa-arrow-right text-xs" aria-hidden="true"></i>
                            </a>
                        </div>

                    </div>

                @endif

            @endforeach

        </div>

    </div>
</section>
@endsection