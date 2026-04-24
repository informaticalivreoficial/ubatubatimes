@extends('web.master.master')


@section('content')
<section class="py-10 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach ($catEmpresas as $categoria)

                @if ($categoria->companies->isNotEmpty())

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-5">
                        
                        {{-- Título --}}
                        <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                            {{ $categoria->title }}
                        </h3>

                        {{-- Lista --}}
                        <ul class="space-y-4">

                            @foreach ($categoria->companies as $empresa)

                                <li class="flex gap-4 items-start">

                                    {{-- Imagem --}}
                                    <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}">
                                        <img 
                                            src="{{ $empresa->getlogo() }}" 
                                            alt="{{ $empresa->alias_name }}"
                                            class="w-20 h-20 object-contain rounded-lg border"
                                        >
                                    </a>

                                    {{-- Conteúdo --}}
                                    <div class="flex-1">
                                        <h2 class="text-sm font-semibold text-red-700 leading-tight">
                                            <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}">
                                                {{ $empresa->alias_name }}
                                            </a>
                                        </h2>

                                        <p class="text-xs text-gray-600 mt-1 leading-snug">
                                            {!! Words($empresa->content, 10) !!}
                                        </p>

                                        @if($empresa->categoriaObject)
                                            <a 
                                                href="{{ route('web.guiaSubCategoria', $empresa->categoriaObject->slug) }}"
                                                class="text-xs font-semibold text-gray-500 hover:text-gray-700"
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
                                class="inline-block text-sm font-medium text-blue-600 hover:underline"
                            >
                                Ver tudo →
                            </a>
                        </div>

                    </div>

                @endif

            @endforeach

        </div>

    </div>
</section>
@endsection

@section('css')
    <style>
        
    </style>
@endsection

@section('js')
    <script>
             
    </script>
@endsection