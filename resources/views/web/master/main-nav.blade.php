<div x-data="{ mobileOpen: false, colunasOpen: false, regiaoOpen: false, searchOpen: false }"
    class="bg-white sticky top-0 z-50 shadow-sm">
    <div class="container mx-auto px-4">

        {{-- Desktop / Tablet --}}
        <div class="hidden md:flex items-center justify-between min-h-[64px]">
            <ul class="flex items-stretch flex-wrap">

                {{-- GUIA --}}
                <li>
                    <a href="{{ route('web.guiaUbatuba') }}"
                    class="flex items-center px-3 lg:px-5 py-4 bg-yellow-400 font-black text-xs lg:text-sm tracking-wide hover:bg-yellow-500 transition whitespace-nowrap">
                        GUIA
                    </a>
                </li>

                {{-- PRAIAS DE UBATUBA --}}
                <li>
                    <a href="{{ route('web.blog.categoria', ['slug' => 'praias-de-ubatuba']) }}"
                    class="flex items-center px-3 lg:px-5 py-4 font-bold text-xs lg:text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition whitespace-nowrap">
                        PRAIAS DE UBATUBA
                    </a>
                </li>

                {{-- BLOG --}}
                <li>
                    <a href="{{ route('web.blog.artigos') }}"
                    class="flex items-center px-3 lg:px-5 py-4 font-bold text-xs lg:text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition whitespace-nowrap">
                        BLOG
                    </a>
                </li>

                {{-- COLUNAS --}}
                @if ($catcolunas && $catcolunas->count() > 0)
                    <li class="relative" @click.outside="colunasOpen = false">
                        <button @click="colunasOpen = !colunasOpen"
                                type="button"
                                aria-haspopup="true"
                                :aria-expanded="colunasOpen.toString()"
                                class="flex items-center gap-1 px-3 lg:px-5 py-4 font-bold text-xs lg:text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition h-full whitespace-nowrap"
                                :class="colunasOpen ? 'text-red-600 border-red-600' : ''">
                            COLUNAS <i class="fa fa-angle-down text-xs transition-transform" :class="colunasOpen ? 'rotate-180' : ''"></i>
                        </button>
                        <ul x-show="colunasOpen"
                            x-transition
                            x-cloak
                            class="absolute top-full left-0 mt-1 w-[280px] max-h-[70vh] overflow-y-auto rounded-xl bg-white shadow-2xl border border-slate-100 z-50">
                            @foreach ($catcolunas as $catc)
                                @if ($catc->posts->count() >= 1)
                                    <li class="border-b border-gray-100 last:border-b-0">
                                        <a href="{{ route('web.blog.categoria', ['slug' => $catc->slug]) }}"
                                        class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:text-red-600 hover:bg-gray-50 transition">
                                            <span class="text-red-500">»</span> {{ $catc->title }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif

                {{-- REGIÃO --}}
                @if ($catnoticias && $catnoticias->count() > 0)
                    <li class="relative" @click.outside="regiaoOpen = false">
                        <button @click="regiaoOpen = !regiaoOpen"
                                type="button"
                                aria-haspopup="true"
                                :aria-expanded="regiaoOpen.toString()"
                                class="flex items-center gap-1 px-3 lg:px-5 py-4 font-bold text-xs lg:text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition h-full whitespace-nowrap"
                                :class="regiaoOpen ? 'text-red-600 border-red-600' : ''">
                            REGIÃO <i class="fa fa-angle-down text-xs transition-transform" :class="regiaoOpen ? 'rotate-180' : ''"></i>
                        </button>
                        <ul x-show="regiaoOpen"
                            x-transition
                            x-cloak
                            class="absolute top-full left-0 mt-1 w-[280px] max-h-[70vh] overflow-y-auto rounded-xl bg-white shadow-2xl border border-slate-100 z-50">
                            @foreach ($catnoticias as $catn)
                                @if ($catn->posts->count() >= 1)
                                    <li class="border-b border-gray-100 last:border-b-0">
                                        <a href="{{ route('web.noticia.categoria', ['slug' => $catn->slug]) }}"
                                        class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:text-red-600 hover:bg-gray-50 transition">
                                            <span class="text-red-500">»</span> {{ $catn->title }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif

                {{-- WIKI UBATUBA --}}
                <li>
                    <a href="{{ route('web.blog.categoria', ['slug' => 'wiki-ubatuba']) }}"
                    class="flex items-center px-3 lg:px-5 py-4 font-bold text-xs lg:text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition whitespace-nowrap">
                        WIKI UBATUBA
                    </a>
                </li>

            </ul>

            {{-- Search toggle --}}
            <div class="flex items-center gap-3 flex-shrink-0" @click.outside="searchOpen = false">
                <button @click="searchOpen = !searchOpen"
                        type="button"
                        aria-label="Abrir pesquisa"
                        :aria-expanded="searchOpen.toString()"
                        class="w-9 h-9 bg-red-600 text-white rounded flex items-center justify-center hover:bg-red-700 transition">
                    <i class="fa" :class="searchOpen ? 'fa-times' : 'fa-search'" style="font-size:14px"></i>
                </button>
            </div>
        </div>

        {{-- Search bar (desktop/tablet) --}}
        <div x-show="searchOpen" x-transition x-cloak class="hidden md:block py-3 border-t">
            <form action="{{ route('web.pesquisa') }}" method="post">
                @csrf
                <div class="flex gap-2 max-w-xl">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Pesquisar..."
                        autofocus
                        class="flex-1 border-2 border-gray-200 rounded px-4 py-2 text-sm focus:outline-none focus:border-red-500">
                    <button type="submit"
                            class="px-5 py-2 bg-red-600 text-white rounded text-sm font-bold hover:bg-red-700 transition flex-shrink-0">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Mobile toggle --}}
        <div class="md:hidden flex items-center justify-between py-2">
            <button @click="mobileOpen = !mobileOpen"
                    type="button"
                    aria-label="Abrir menu"
                    :aria-expanded="mobileOpen.toString()"
                    class="p-2 text-gray-700 font-bold text-sm flex items-center gap-2">
                <i class="fa" :class="mobileOpen ? 'fa-times' : 'fa-bars'"></i> MENU
            </button>
            <a href="{{ route('web.guiaUbatuba') }}" class="font-black text-sm tracking-wide text-gray-900">
                UBATUBA
            </a>
            <button @click="searchOpen = !searchOpen"
                    type="button"
                    aria-label="Abrir pesquisa"
                    :aria-expanded="searchOpen.toString()"
                    class="w-8 h-8 bg-red-600 text-white rounded flex items-center justify-center">
                <i class="fa" :class="searchOpen ? 'fa-times' : 'fa-search'" style="font-size:12px"></i>
            </button>
        </div>

        {{-- Search bar (mobile) --}}
        <div x-show="searchOpen" x-transition x-cloak class="md:hidden py-3 border-t">
            <form action="{{ route('web.pesquisa') }}" method="post">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Pesquisar..."
                        class="flex-1 border-2 border-gray-200 rounded px-4 py-2 text-sm focus:outline-none focus:border-red-500">
                    <button type="submit"
                            class="px-5 py-2 bg-red-600 text-white rounded text-sm font-bold hover:bg-red-700 transition flex-shrink-0">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobileOpen" x-transition x-cloak class="md:hidden border-t max-h-[80vh] overflow-y-auto">
            <ul>
                <li>
                    <a href="{{ route('web.guiaUbatuba') }}"
                    class="flex items-center px-4 py-3 bg-yellow-400 font-black text-sm tracking-wide">
                        GUIA
                    </a>
                </li>
                <li class="border-b">
                    <a href="{{ route('web.blog.categoria', ['slug' => 'praias-de-ubatuba']) }}"
                    class="block px-4 py-3 font-bold text-sm text-gray-800">PRAIAS DE UBATUBA</a>
                </li>
                <li class="border-b">
                    <a href="{{ route('web.blog.artigos') }}"
                    class="block px-4 py-3 font-bold text-sm text-gray-800">BLOG</a>
                </li>

                @if ($catcolunas && $catcolunas->count() > 0)
                    <li x-data="{ open: false }" class="border-b">
                        <button @click="open = !open"
                                type="button"
                                aria-haspopup="true"
                                :aria-expanded="open.toString()"
                                class="flex items-center justify-between w-full px-4 py-3 font-bold text-sm text-gray-800">
                            COLUNAS <i class="fa fa-angle-down transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <ul x-show="open" x-collapse x-cloak class="bg-gray-50">
                            @foreach ($catcolunas as $catc)
                                @if ($catc->posts->count() >= 1)
                                    <li class="border-t border-gray-100">
                                        <a href="{{ route('web.blog.categoria', ['slug' => $catc->slug]) }}"
                                        class="flex items-center gap-2 px-6 py-2 text-sm text-gray-700">
                                            <span class="text-red-500">»</span> {{ $catc->title }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif

                @if ($catnoticias && $catnoticias->count() > 0)
                    <li x-data="{ open: false }" class="border-b">
                        <button @click="open = !open"
                                type="button"
                                aria-haspopup="true"
                                :aria-expanded="open.toString()"
                                class="flex items-center justify-between w-full px-4 py-3 font-bold text-sm text-gray-800">
                            REGIÃO <i class="fa fa-angle-down transition-transform" :class="open ? 'rotate-180' : ''"></i>
                        </button>
                        <ul x-show="open" x-collapse x-cloak class="bg-gray-50">
                            @foreach ($catnoticias as $catn)
                                @if ($catn->posts->count() >= 1)
                                    <li class="border-t border-gray-100">
                                        <a href="{{ route('web.noticia.categoria', ['slug' => $catn->slug]) }}"
                                        class="flex items-center gap-2 px-6 py-2 text-sm text-gray-700">
                                            <span class="text-red-500">»</span> {{ $catn->title }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </li>
                @endif

                <li class="border-b">
                    <a href="{{ route('web.blog.categoria', ['slug' => 'wiki-ubatuba']) }}"
                    class="block px-4 py-3 font-bold text-sm text-gray-800">WIKI UBATUBA</a>
                </li>
            </ul>
        </div>

    </div>
</div>