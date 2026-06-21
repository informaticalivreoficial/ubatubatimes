@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Navegação de páginas" class="flex items-center justify-center">
        <ul class="flex flex-wrap items-center gap-2">

            {{-- Botão Anterior --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span aria-disabled="true" aria-label="Anterior"
                          class="flex h-10 w-10 cursor-not-allowed items-center justify-center rounded-full border border-slate-200 text-slate-300">
                        <i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i>
                    </span>
                </li>
            @else
                <li>
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Anterior"
                       class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition hover:border-red-500 hover:bg-red-600 hover:text-white">
                        <i class="fa-solid fa-chevron-left text-xs" aria-hidden="true"></i>
                    </a>
                </li>
            @endif

            {{-- Elementos de paginação --}}
            @foreach ($elements as $element)

                {{-- Separador "..." --}}
                @if (is_string($element))
                    <li>
                        <span class="flex h-10 w-10 items-center justify-center text-sm font-medium text-slate-400">
                            {{ $element }}
                        </span>
                    </li>
                @endif

                {{-- Array de links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span aria-current="page"
                                      class="flex h-10 w-10 items-center justify-center rounded-full bg-red-600 text-sm font-bold text-white">
                                    {{ $page }}
                                </span>
                            </li>
                        @else
                            <li>
                                <a href="{{ $url }}"
                                   class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-sm font-semibold text-slate-600 transition hover:border-red-500 hover:bg-red-600 hover:text-white">
                                    {{ $page }}
                                </a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Botão Próximo --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Próximo"
                       class="flex h-10 w-10 items-center justify-center rounded-full border border-slate-200 text-slate-600 transition hover:border-red-500 hover:bg-red-600 hover:text-white">
                        <i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
                    </a>
                </li>
            @else
                <li>
                    <span aria-disabled="true" aria-label="Próximo"
                          class="flex h-10 w-10 cursor-not-allowed items-center justify-center rounded-full border border-slate-200 text-slate-300">
                        <i class="fa-solid fa-chevron-right text-xs" aria-hidden="true"></i>
                    </span>
                </li>
            @endif

        </ul>
    </nav>
@endif