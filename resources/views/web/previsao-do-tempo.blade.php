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
                <span class="text-slate-800 font-medium">Previsão do tempo para Ubatuba</span>
            </li>
        </ul>
    </div>
</div>

<section class="py-8">
    <div class="mx-auto max-w-7xl px-4">
        @if (!empty($boletim))

            <div class="mb-6 flex items-center gap-2">
                <i class="fa-solid fa-cloud-sun text-xl text-amber-500" aria-hidden="true"></i>
                <h3 class="text-lg font-bold text-slate-800">
                    Atualização: <span class="text-red-600">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>
                </h3>
            </div>

            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($boletim as $item)
                    <div class="rounded-xl border border-slate-200 bg-white p-4 text-center shadow-sm transition hover:shadow-md">
                        <img src="{{ asset('frontend/assets/images/' . $item['img']) }}"
                             alt="{{ $item['previsao'] }}"
                             class="mx-auto mb-2 h-16">

                        <p class="text-sm font-bold text-slate-900">{{ $item['data'] }}</p>
                        <p class="mb-3 text-sm text-slate-500">{{ $item['previsao'] }}</p>

                        <div class="flex items-center justify-center gap-3 text-sm text-slate-700">
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-temperature-arrow-down text-sky-500" aria-hidden="true"></i>
                                {{ $item['minima'] }}&deg;
                            </span>
                            <span class="flex items-center gap-1">
                                <i class="fa-solid fa-temperature-arrow-up text-red-500" aria-hidden="true"></i>
                                {{ $item['maxima'] }}&deg;
                            </span>
                        </div>

                        <p class="mt-3 flex items-center justify-center gap-1.5 text-xs">
                            <span class="font-medium text-slate-500">Índice UV</span>
                            <span class="rounded px-2 py-0.5 text-xs font-bold" style="{{ $item['iuvcolor'] }}">
                                {{ $item['iuv'] }}
                            </span>
                        </p>
                    </div>
                @endforeach
            </div>

        @else
            <div class="flex flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-slate-50 py-16 text-center">
                <i class="fa-solid fa-cloud-question text-3xl text-slate-300" aria-hidden="true"></i>
                <p class="text-sm text-slate-500">Boletim de previsão indisponível no momento.</p>
            </div>
        @endif
    </div>
</section>

@endsection