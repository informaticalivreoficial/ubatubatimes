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
                <a href="{{ route('web.guiaUbatuba') }}" class="hover:text-red-600 transition">Guia</a>
            </li>

            @if ($subcategoria->parent)
                <li class="flex items-center gap-2">
                    <i class="fa-solid fa-chevron-right text-xs text-slate-400" aria-hidden="true"></i>
                    <a href="{{ route('web.guiaCategoria', $subcategoria->parent->slug) }}" class="hover:text-red-600 transition">
                        {{ $subcategoria->parent->title }}
                    </a>
                </li>
            @endif

            <li class="flex items-center gap-2">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400" aria-hidden="true"></i>
                <span class="text-slate-800 font-medium">{{ $subcategoria->title }}</span>
            </li>
        </ul>
    </div>
</div>

<section class="bg-slate-50 py-10">
    <div class="mx-auto max-w-7xl px-4">

        {{-- Título --}}
        <h1 class="mb-6 text-2xl font-bold text-slate-800">
            {{ $subcategoria->title }}
        </h1>

        {{-- Lista --}}
        @if ($empresas->isNotEmpty())

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($empresas as $empresa)

                    <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md">

                        {{-- Logo --}}
                        <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}" class="block">
                            <img
                                src="{{ $empresa->getlogo() }}"
                                alt="{{ $empresa->alias_name }}"
                                class="mb-3 h-32 w-full object-contain"
                            >
                        </a>

                        {{-- Nome --}}
                        <h2 class="mb-1 text-sm font-semibold text-red-700">
                            <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}" class="hover:text-red-800">
                                {{ $empresa->alias_name }}
                            </a>
                        </h2>

                        {{-- Descrição --}}
                        <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}" class="block text-xs leading-snug text-slate-600">
                            {!! Words($empresa->content, 14) !!}
                        </a>

                    </div>

                @endforeach

            </div>

            {{-- Paginação --}}
            <div class="mt-8">
                {{ $empresas->links() }}
            </div>

        @else

            <div class="flex flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white py-16 text-center">
                <i class="fa-solid fa-shop-slash text-3xl text-slate-300" aria-hidden="true"></i>
                <p class="text-sm text-slate-500">Nenhuma empresa encontrada nesta subcategoria.</p>
            </div>

        @endif

    </div>
</section>
@endsection