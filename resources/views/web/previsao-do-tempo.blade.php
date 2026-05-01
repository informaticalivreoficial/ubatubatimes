@extends('web.master.master')

@section('content')
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li>Previsão do tempo para Ubatuba</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="py-8">
    <div class="container mx-auto px-4">
        @if(!empty($boletim))

            <h3 class="text-lg font-bold mb-6">
                Atualização: <span class="text-red-600">{{ Carbon\Carbon::now()->format('d/m/Y') }}</span>
            </h3>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach ($boletim as $item)
                    <div class="text-center border-b-4 border-gray-200 pb-4">
                        <img src="{{ asset('frontend/assets/images/' . $item['img']) }}" 
                             alt="{{ $item['previsao'] }}" 
                             class="mx-auto mb-2 h-16">
                        <p class="font-bold text-sm">{{ $item['data'] }}</p>
                        <p class="text-sm text-gray-600 mb-2">{{ $item['previsao'] }}</p>
                        <p class="text-sm"><b>Mínima:</b> {{ $item['minima'] }}&deg;</p>
                        <p class="text-sm"><b>Máxima:</b> {{ $item['maxima'] }}&deg;</p>  {{-- ❌ estava "Mínima" duas vezes --}}
                        <p class="text-sm mt-1">
                            <b>Índice UV:</b>
                            <span class="px-2 py-1 rounded text-xs font-bold" style="{{ $item['iuvcolor'] }}">
                                {{ $item['iuv'] }}
                            </span>
                        </p>
                    </div>
                @endforeach
            </div>

        @endif
    </div>
</section>
@endsection