<div id="top-bar" class="border-b border-slate-200 bg-white">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex flex-col gap-3 py-3 md:flex-row md:items-center md:justify-between">

            {{-- Links --}}
            <nav aria-label="Atalhos de praia e clima">
                <ul class="flex flex-wrap items-center justify-center gap-2 md:justify-start">

                    <li>
                        <a href="{{ route('web.ondas') }}" title="Boletim das Ondas"
                           class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-sky-500 hover:bg-sky-50 hover:text-sky-700">
                            <i class="fas fa-water text-sky-600" aria-hidden="true"></i>
                            <span class="hidden sm:inline">Boletim das Ondas</span>
                            <span class="sm:hidden sr-only">Boletim das Ondas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('web.tempo') }}" title="Previsão do Tempo"
                           class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-amber-500 hover:bg-amber-50 hover:text-amber-700">
                            <i class="fas fa-cloud-sun text-amber-500" aria-hidden="true"></i>
                            <span class="hidden sm:inline">Previsão do Tempo</span>
                            <span class="sm:hidden sr-only">Previsão do Tempo</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('web.balneabilidade') }}" title="Condição das Praias"
                           class="flex items-center gap-2 rounded-lg border border-slate-200 bg-slate-50 px-3 py-2 text-sm font-medium text-slate-700 transition hover:border-emerald-500 hover:bg-emerald-50 hover:text-emerald-700">
                            <i class="fas fa-umbrella-beach text-emerald-600" aria-hidden="true"></i>
                            <span class="hidden sm:inline">Condição das Praias</span>
                            <span class="sm:hidden sr-only">Condição das Praias</span>
                        </a>
                    </li>

                </ul>
            </nav>

            {{-- Cotação --}}
            @if($cotacao)
                <div class="flex items-center justify-center gap-2 text-sm md:justify-end">
                    <span class="font-semibold text-slate-800">
                        {{ $cotacao['name'] }}
                    </span>
                    <span class="text-slate-600">
                        R$ {{ $cotacao['ask'] }}
                    </span>
                    <span class="inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-semibold {{ $cotacao['cor'] }}">
                        {{ $cotacao['pct'] }}%
                    </span>
                </div>
            @endif

        </div>
    </div>
</div>

<header id="header" class="bg-white">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex flex-col items-center gap-4 py-4 md:flex-row md:justify-between">

            {{-- Logo --}}
            <div class="flex justify-center md:justify-start">
                <a href="{{ route('web.home') }}">
                    <img
                        src="{{ $config->getlogo() }}"
                        alt="{{ $config->app_name }}"
                        class="h-16 w-auto md:h-20"
                    >
                </a>
            </div>

            {{-- Banner --}}
            <div class="w-full md:w-auto flex justify-center md:justify-end">
                <div class="w-full max-w-[728px]">
                    <x-ad slot="home_top" />
                </div>
            </div>

        </div>
    </div>
</header>