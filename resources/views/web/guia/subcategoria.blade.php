@extends('web.master.master')

@section('content')

<section class="py-10 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4">

        {{-- Breadcrumb --}}
        <div class="mb-6 text-sm text-gray-500 flex flex-wrap gap-2">
            <ul class="flex flex-wrap gap-2 text-sm text-gray-500">
    <li><a href="{{ route('web.home') }}">Início</a></li>
    <li>/</li>

    <li><a href="{{ route('web.guiaUbatuba') }}">Guia</a></li>
    <li>/</li>

    @if($empresa->categoria)
        <li>
            <a href="{{ route('web.guiaCategoria', $empresa->categoria->slug) }}">
                {{ $empresa->categoria->title }}
            </a>
        </li>
        <li>/</li>
    @endif

    @if($empresa->subcategoria)
        <li>
            <a href="{{ route('web.guiaSubCategoria', $empresa->subcategoria->slug) }}">
                {{ $empresa->subcategoria->title }}
            </a>
        </li>
        <li>/</li>
    @endif

    <li class="text-gray-700 font-semibold">
        {{ $empresa->alias_name }}
    </li>
</ul>
        </div>

        {{-- Título --}}
        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            {{ $subcategoria->title }}
        </h1>

        {{-- Lista --}}
        @if($empresas->isNotEmpty())

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                @foreach ($empresas as $empresa)

                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition">

                        {{-- Logo --}}
                        <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}">
                            <img 
                                src="{{ $empresa->getlogo() }}"
                                alt="{{ $empresa->alias_name }}"
                                class="w-full h-32 object-contain mb-3"
                            >
                        </a>

                        {{-- Nome --}}
                        <h2 class="text-sm font-semibold text-red-700 mb-1">
                            <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}">
                                {{ $empresa->alias_name }}
                            </a>
                        </h2>

                        {{-- Descrição --}}
                        <p class="text-xs text-gray-600 leading-snug">
                            <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}">
                                {!! Words($empresa->content, 14) !!}
                            </a>
                        </p>

                    </div>

                @endforeach

            </div>

            {{-- Paginação --}}
            <div class="mt-8">
                {{ $empresas->links() }}
            </div>

        @else

            <div class="text-center text-gray-500 py-10">
                Nenhuma empresa encontrada nesta subcategoria.
            </div>

        @endif

    </div>
</section>
@endsection

@section('css')
    <style>
        .pagination-custom{
            margin: 0;
            display: -ms-flexbox;
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
        }
        .pagination-custom li a {
            border-radius: 30px;
            margin-right: 8px;
            color:#7c7c7c;
            border: 1px solid #ddd;
            position: relative;
            float: left;
            padding: 6px 12px;
            width: 40px;
            height: 40px;
            text-align: center;
            line-height: 25px;
            font-weight: 600;
        }
        .pagination-custom>.active>a, .pagination-custom>.active>a:hover, .pagination-custom>li>a:hover {
            color: #fff;
            background: #ec0000;
            border: 1px solid transparent;
        }
        .imgbox{
            float: left;
            padding-right: 10px;
        }        
        .imgbox img{
            max-width: 120px;
            min-height: 75px;
            border-radius: 2px;
            box-shadow: 0 2px 3px rgb(0 0 0 / 10%);
        }   
        .alink{
            color: #333;
        }     
    </style>
@endsection