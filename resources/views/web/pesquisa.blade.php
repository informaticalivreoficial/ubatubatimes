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
                <a href="{{ route('web.pesquisa') }}" class="text-slate-800 font-medium hover:text-red-600 transition">Pesquisa no site</a>
            </li>
        </ul>
    </div>
</div>

{{-- Formulário de busca --}}
<section class="py-6">
    <div class="mx-auto max-w-7xl px-4">
        <div class="mx-auto max-w-2xl">
            <form action="{{ route('web.pesquisa') }}" method="post">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Digite sua pesquisa..."
                           class="flex-1 rounded border-2 border-slate-300 px-4 py-3 text-sm focus:border-red-500 focus:outline-none">
                    <button type="submit"
                            class="flex items-center gap-2 rounded bg-red-600 px-6 py-3 font-bold text-white transition hover:bg-red-700">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i> Pesquisar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

{{-- Resultados --}}
<section class="py-6">
    <div class="mx-auto max-w-7xl px-4">

        @if ($search && $data && count($data) > 0)

            <p class="mb-4 text-sm text-slate-500">
                Resultados para: <strong class="text-slate-800">{{ $search }}</strong>
            </p>

            <div class="flex flex-col gap-6">
                @foreach ($data as $item)
                    <div class="border-b border-slate-200 pb-5">
                        <div class="mb-1 flex flex-wrap items-center gap-2">
                            <span class="rounded bg-red-600 px-2 py-1 text-xs font-bold uppercase text-white">
                                {{ $item['type'] }}
                            </span>
                            <a href="{{ $item['link'] }}" class="font-semibold text-blue-700 hover:underline">
                                {{ $item['title'] }}
                            </a>
                        </div>
                        <p class="mt-2 text-sm leading-relaxed text-slate-600">
                            {!! \App\Helpers\Renato::Words($item['desc'], 30) !!}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $data->links() }}
            </div>

        @elseif ($search)
            <div class="flex flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-slate-50 py-16 text-center">
                <i class="fa-solid fa-magnifying-glass text-3xl text-slate-300" aria-hidden="true"></i>
                <p class="text-sm text-slate-500">
                    Nenhum resultado encontrado para <strong class="text-slate-700">{{ $search }}</strong>.
                </p>
            </div>
        @endif

    </div>
</section>

@endsection