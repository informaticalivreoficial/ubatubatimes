@extends('web.master.master')

@section('content')

<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li><a href="{{route('web.pesquisa')}}">Pesquisa no site</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="py-6">
    <div class="container mx-auto px-4">
        <div class="max-w-2xl mx-auto">
            <form action="{{ route('web.pesquisa') }}" method="post">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                           placeholder="Digite sua pesquisa..."
                           class="flex-1 border-2 border-gray-300 rounded px-4 py-3 text-sm focus:outline-none focus:border-red-500">
                    <button type="submit"
                            class="px-6 py-3 bg-red-600 text-white font-bold rounded hover:bg-red-700 transition">
                        <i class="fa fa-search mr-1"></i> Pesquisar
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<section class="py-6">
    <div class="container mx-auto px-4">

        @if ($search && $data && count($data) > 0)

            <p class="text-sm text-gray-500 mb-4">
                Resultados para: <strong>{{ $search }}</strong>
            </p>

            <div class="space-y-6">
                @foreach ($data as $item)
                    <div class="border-b pb-4">
                        <span class="text-xs font-bold uppercase bg-red-600 text-white px-2 py-1 rounded mr-2">
                            {{ $item['type'] }} {{-- ❌ era 'tipo' --}}
                        </span>
                        <a href="{{ $item['link'] }}" class="text-blue-700 font-semibold hover:underline">
                            {{ $item['title'] }} {{-- ❌ era 'titulo' --}}
                        </a>
                        <p class="text-sm text-gray-600 mt-2">
                            {!! \App\Helpers\Renato::Words($item['desc'], 30) !!}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $data->links() }}
            </div>

        @elseif($search)
            <p class="text-center text-gray-500 py-8">
                Nenhum resultado encontrado para <strong>{{ $search }}</strong>.
            </p>
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
    .linksearch{
        color: #2083f4;
    }
    .linksearch:hover{
        color: #F48920;
        text-decoration: underline;
    }
</style>
@endsection