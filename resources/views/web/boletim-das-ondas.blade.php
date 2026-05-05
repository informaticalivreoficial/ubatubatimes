@extends('web.master.master')

@section('content')
<section class="utf_block_wrapper">
    <div class="container">
        <div class="mx-auto">

            <h1 class="text-2xl font-bold mb-6">
                🌊 Boletim das Ondas - Ubatuba
            </h1>

            @if($dados)

                @if(!empty($dados['resumo']['geral']))
                    <div class="bg-white rounded-xl shadow p-4 mb-5">
                        <p class="text-gray-600 text-sm">
                            Atualização: <span class="text-red-600">{{ Carbon\Carbon::now()->format('d/m/Y') }}</span><br>
                            {{ $dados['resumo']['geral'] }}
                        </p>
                    </div>
                @endif

                @php
                    $periodos = [
                        'manha' => '🌅 Manhã',
                        'tarde' => '🌇 Tarde',
                    ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-stretch">

                    @foreach($periodos as $key => $label)
                        @php $item = $dados[$key] ?? null; @endphp

                        <div class="bg-white rounded-xl shadow p-4 flex flex-col h-full">

                            <h2 class="font-semibold text-base mb-2">
                                {{ $label }}
                            </h2>

                            <div class="flex items-center gap-3 mb-3">
                                <img src="{{ $item['img'] ?? '' }}" class="w-10 h-10 object-contain">
                                <span class="text-base font-medium">
                                    {{ $item['altura'] ?? '-' }}
                                </span>
                            </div>

                            <div class="flex-1">
                                <ul class="text-sm space-y-1">
                                    <li>
                                        🌬️ {{ $item['vento'] ?? '-' }} km/h ({{ $item['vento_dir'] ?? '-' }})
                                    </li>

                                    <li>
                                        🌊 {{ $item['direcao_onda'] ?? '-' }}
                                    </li>
                                </ul>

                                @if(!empty($dados['resumo'][$key]))
                                    <p class="text-xs mt-3 text-gray-500 italic">
                                        {{ $dados['resumo'][$key] }}
                                    </p>
                                @endif
                            </div>

                        </div>
                    @endforeach

                </div>

                {{-- MARÉ --}}
                @if(!empty($dados['mares']))
                    <div class="bg-white rounded-xl shadow p-4 mt-6">

                        <h2 class="font-semibold text-base mb-3">
                            🌊 Marés
                        </h2>

                        <div class="grid grid-cols-3 md:grid-cols-6 gap-2">

                            @foreach($dados['mares'] as $mare)
                                <div class="text-center border rounded-lg p-2 bg-gray-50">

                                    <div class="text-[10px] text-gray-500">
                                        {{ $mare['tipo'] }}
                                    </div>

                                    <div class="text-sm font-bold">
                                        {{ $mare['hora'] }}
                                    </div>

                                    @if(!empty($mare['altura']))
                                        <div class="text-xs text-gray-600">
                                            {{ $mare['altura'] }}m
                                        </div>
                                    @endif

                                </div>
                            @endforeach

                        </div>

                    </div>
                @endif

            @else
                <p class="text-red-500">Não foi possível carregar o boletim.</p>
            @endif

        </div>
    </div>
    
</section>
@endsection