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
                <span class="text-slate-800 font-medium">Boletim das Ondas</span>
            </li>
        </ul>
    </div>
</div>

<section class="py-8">
    <div class="mx-auto max-w-7xl px-4">

        <div class="mb-6 flex items-center gap-2">
            <i class="fa-solid fa-water text-xl text-sky-600" aria-hidden="true"></i>
            <h1 class="text-xl font-bold text-slate-900 sm:text-2xl">
                Boletim das Ondas - Ubatuba
            </h1>
        </div>

        @if ($dados)

            @if (!empty($dados['resumo']['geral']))
                <div class="mb-5 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
                    <p class="text-sm text-slate-600">
                        Atualização: <span class="font-medium text-red-600">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</span>
                    </p>
                    <p class="mt-1 text-sm leading-relaxed text-slate-700">
                        {{ $dados['resumo']['geral'] }}
                    </p>
                </div>
            @endif

            @php
                $periodos = [
                    'manha' => ['label' => 'Manhã', 'icon' => 'fa-sun'],
                    'tarde' => ['label' => 'Tarde', 'icon' => 'fa-cloud-sun'],
                ];
            @endphp

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">

                @foreach ($periodos as $key => $periodo)
                    @php $item = $dados[$key] ?? null; @endphp

                    <div class="flex h-full flex-col rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

                        <h2 class="mb-3 flex items-center gap-2 text-base font-semibold text-slate-900">
                            <i class="fa-solid {{ $periodo['icon'] }} text-amber-500" aria-hidden="true"></i>
                            {{ $periodo['label'] }}
                        </h2>

                        <div class="mb-3 flex items-center gap-3">
                            @if (!empty($item['img']))
                                <img src="{{ $item['img'] }}" alt="" class="h-10 w-10 object-contain">
                            @endif
                            <span class="text-base font-medium text-slate-900">
                                {{ $item['altura'] ?? '-' }}
                            </span>
                        </div>

                        <div class="flex-1">
                            <ul class="flex flex-col gap-1.5 text-sm text-slate-600">
                                <li class="flex items-center gap-2">
                                    <i class="fa-solid fa-wind text-slate-400" aria-hidden="true"></i>
                                    {{ $item['vento'] ?? '-' }} km/h ({{ $item['vento_dir'] ?? '-' }})
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class="fa-solid fa-water text-sky-500" aria-hidden="true"></i>
                                    {{ $item['direcao_onda'] ?? '-' }}
                                </li>
                            </ul>

                            @if (!empty($dados['resumo'][$key]))
                                <p class="mt-3 text-xs italic text-slate-500">
                                    {{ $dados['resumo'][$key] }}
                                </p>
                            @endif
                        </div>

                    </div>
                @endforeach

            </div>

            {{-- Maré --}}
            @if (!empty($dados['mares']))
                <div class="mt-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">

                    <h2 class="mb-3 flex items-center gap-2 text-base font-semibold text-slate-900">
                        <i class="fa-solid fa-water text-sky-600" aria-hidden="true"></i>
                        Marés
                    </h2>

                    <div class="grid grid-cols-3 gap-2 md:grid-cols-6">
                        @foreach ($dados['mares'] as $mare)
                            <div class="rounded-lg border border-slate-200 bg-slate-50 p-2 text-center">
                                <div class="text-[10px] uppercase tracking-wide text-slate-500">
                                    {{ $mare['tipo'] }}
                                </div>
                                <div class="text-sm font-bold text-slate-900">
                                    {{ $mare['hora'] }}
                                </div>
                                @if (!empty($mare['altura']))
                                    <div class="text-xs text-slate-500">
                                        {{ $mare['altura'] }}m
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>

                </div>
            @endif

        @else
            <div class="flex flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-slate-50 py-16 text-center">
                <i class="fa-solid fa-circle-exclamation text-3xl text-red-400" aria-hidden="true"></i>
                <p class="text-sm text-slate-500">Não foi possível carregar o boletim.</p>
            </div>
        @endif

    </div>
</section>
@endsection