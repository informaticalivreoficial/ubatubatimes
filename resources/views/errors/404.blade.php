@extends('web.master.master')

@section('title', __('Página não encontrada'))

@section('content')
    <section class="flex min-h-[60vh] items-center justify-center bg-slate-50 px-4 py-16">
        <div class="w-full max-w-md text-center">

            <i class="fa-solid fa-compass mb-4 text-5xl text-red-500" aria-hidden="true"></i>

            <h2 class="text-2xl font-bold text-slate-800">
                Desculpe, página não encontrada
            </h2>
            <p class="mt-2 text-sm text-slate-500">
                O conteúdo que você procura pode ter sido movido ou não existe mais.
            </p>

            <form action="{{ route('web.pesquisa') }}" method="post" class="mt-6">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="search" id="s"
                           placeholder="Pesquisar no site..."
                           class="flex-1 rounded border-2 border-slate-300 px-4 py-2.5 text-sm focus:border-red-500 focus:outline-none">
                    <button type="submit" id="searchsubmit"
                            class="flex items-center gap-2 rounded bg-red-600 px-5 py-2.5 text-sm font-bold text-white transition hover:bg-red-700">
                        <i class="fa-solid fa-magnifying-glass" aria-hidden="true"></i>
                    </button>
                </div>
            </form>

            <div class="mt-6">
                <a href="{{ route('web.home') }}"
                   title="Voltar para Home"
                   class="inline-flex items-center gap-2 rounded-lg border border-slate-300 px-5 py-2.5 text-sm font-medium text-slate-700 transition hover:border-red-500 hover:text-red-600">
                    <i class="fa-solid fa-house" aria-hidden="true"></i> Voltar para Home
                </a>
            </div>

        </div>
    </section>
@endsection