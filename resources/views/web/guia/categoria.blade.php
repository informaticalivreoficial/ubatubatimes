@extends('web.master.master')

@section('content')

<section class="py-8 bg-gray-50">

    <div class="max-w-7xl mx-auto px-4">

        {{-- Breadcrumb --}}
        <nav class="text-sm text-gray-500 mb-6 flex flex-wrap gap-2">
            <a href="{{ route('web.home') }}" class="hover:underline">Início</a>
            <span>/</span>

            <a href="{{ route('web.guiaUbatuba') }}" class="hover:underline">Guia</a>
            <span>/</span>

            <span class="text-gray-700 font-medium">
                {{ $categoria->title }}
            </span>
        </nav>

        {{-- Título --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            {{ $categoria->title }}
        </h1>

        {{-- Lista --}}
        @if($empresas->isNotEmpty())

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($empresas as $empresa)

                    <div class="bg-white rounded-xl shadow-sm border p-4 flex gap-4 hover:shadow-md transition">

                        {{-- Logo --}}
                        <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}">
                            <img 
                                src="{{ $empresa->getlogo() }}"
                                alt="{{ $empresa->alias_name }}"
                                class="w-20 h-20 object-contain rounded border"
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
                                {!! Words($empresa->content, 12) !!}
                            </p>

                            @if($empresa->categoriaObject)
                                <a 
                                    href="{{ route('web.guiaSubCategoria', $empresa->categoriaObject->slug) }}"
                                    class="text-xs font-medium text-gray-500 hover:text-gray-700"
                                >
                                    {{ $empresa->categoriaObject->title }}
                                </a>
                            @endif

                        </div>

                    </div>

                @endforeach

            </div>

            {{-- Paginação --}}
            <div class="mt-8">
                {{ $empresas->links() }}
            </div>

        @else

            <div class="text-center py-12 text-gray-500">
                Nenhuma empresa encontrada nesta categoria.
            </div>

        @endif

    </div>

</section>
@endsection

@section('css')
    <style>
           
    </style>
@endsection