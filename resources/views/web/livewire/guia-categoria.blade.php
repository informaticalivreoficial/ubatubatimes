<section class="bg-slate-50 py-8" wire:ignore.self>
    <div class="mx-auto max-w-7xl px-4">

        {{-- Filtros --}}
        <div class="mb-6 rounded-xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

                {{-- Busca --}}
                <div class="sm:col-span-1">
                    <label class="mb-1 block text-xs font-medium text-slate-500">Buscar</label>
                    <div class="relative">
                        <input
                            type="text"
                            wire:model.live.debounce.300ms="search"
                            placeholder="Nome da empresa..."
                            class="w-full rounded-lg border border-slate-300 py-2 pl-9 pr-3 text-sm text-slate-700 placeholder-slate-400 transition focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500"
                        >
                        <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" aria-hidden="true"></i>
                    </div>
                </div>

                {{-- Subcategoria --}}
                <div class="sm:col-span-1">
                    <label class="mb-1 block text-xs font-medium text-slate-500">Subcategoria</label>
                    <select
                        wire:model.live="subcategoryId"
                        class="w-full rounded-lg border border-slate-300 py-2 px-3 text-sm text-slate-700 transition focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500"
                    >
                        <option value="">Todas</option>
                        @foreach($subcategories as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->title }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Ordenação --}}
                <div class="sm:col-span-1">
                    <label class="mb-1 block text-xs font-medium text-slate-500">Ordenar por</label>
                    <select
                        wire:model.live="sort"
                        class="w-full rounded-lg border border-slate-300 py-2 px-3 text-sm text-slate-700 transition focus:border-red-500 focus:outline-none focus:ring-1 focus:ring-red-500"
                    >
                        <option value="relevance">Relevância</option>
                        <option value="name">Nome (A-Z)</option>
                        <option value="views">Mais vistos</option>
                        <option value="recent">Mais recentes</option>
                    </select>
                </div>

            </div>
        </div>

        {{-- Resultados --}}
        @if ($empresas->isNotEmpty())

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">

                @foreach ($empresas as $empresa)

                    <div class="flex gap-4 rounded-xl border border-slate-200 bg-white p-4 shadow-sm transition hover:shadow-md">

                        {{-- Logo --}}
                        <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}" class="flex-shrink-0">
                            <img
                                src="{{ $empresa->getlogo() }}"
                                alt="{{ $empresa->alias_name }}"
                                class="h-20 w-20 rounded border border-slate-200 object-contain"
                            >
                        </a>

                        {{-- Conteúdo --}}
                        <div class="min-w-0 flex-1">

                            <h2 class="text-sm font-semibold leading-tight text-red-700">
                                <a href="{{ route('web.guiaEmpresa', $empresa->slug) }}" class="hover:text-red-800">
                                    {{ $empresa->alias_name }}
                                </a>
                            </h2>

                            <p class="mt-1 text-xs leading-snug text-slate-600">
                                {!! Words($empresa->content, 12) !!}
                            </p>

                            @if ($empresa->subcategoriaObject)
                                <a
                                    href="{{ route('web.guiaSubCategoria', $empresa->subcategoriaObject->slug) }}"
                                    class="mt-1 inline-block text-xs font-medium text-slate-500 hover:text-slate-700"
                                >
                                    {{ $empresa->subcategoriaObject->title }}
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

            <div class="flex flex-col items-center justify-center gap-3 rounded-xl border border-slate-200 bg-white py-16 text-center">
                <i class="fa-solid fa-shop-slash text-3xl text-slate-300" aria-hidden="true"></i>
                <p class="text-sm text-slate-500">Nenhuma empresa encontrada.</p>
                @if($search || $subcategoryId)
                    <button
                        wire:click="$set('search', ''); $set('subcategoryId', null)"
                        class="text-sm font-medium text-red-600 hover:underline"
                    >
                        Limpar filtros
                    </button>
                @endif
            </div>

        @endif

    </div>
</section>
