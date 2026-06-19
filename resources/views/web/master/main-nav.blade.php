<div x-data="{ mobileOpen: false, colunasOpen: false, regiaoOpen: false, searchOpen: false }"
    class="bg-white sticky top-0 z-50 shadow-sm">
    <div class="container mx-auto px-4">

        {{-- Desktop --}}
        <div class="hidden lg:flex items-center justify-between">
            <ul class="flex items-stretch">

                {{-- GUIA --}}
                <li>
                    <a href="{{ route('web.guiaUbatuba') }}"
                    class="flex items-center px-5 py-4 bg-yellow-400 font-black text-sm tracking-wide hover:bg-yellow-500 transition">
                        GUIA
                    </a>
                </li>

                {{-- PRAIAS DE UBATUBA --}}
                <li>
                    <a href="{{ route('web.blog.categoria', ['slug' => 'praias-de-ubatuba']) }}"
                    class="flex items-center px-5 py-4 font-bold text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition">
                        PRAIAS DE UBATUBA
                    </a>
                </li>

                {{-- BLOG --}}
                <li>
                    <a href="{{ route('web.blog.artigos') }}"
                    class="flex items-center px-5 py-4 font-bold text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition">
                        BLOG
                    </a>
                </li>

                {{-- COLUNAS --}}
                @if ($catcolunas && $catcolunas->count() > 0)
                    <li class="relative" @click.outside="colunasOpen = false">
                        <button @click="colunasOpen = !colunasOpen"
                                class="flex items-center gap-1 px-5 py-4 font-bold text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition h-full"
                                :class="colunasOpen ? 'text-red-600 border-red-600' : ''">
                            COLUNAS <i class="fa fa-angle-down text-xs"></i>
                        </button>
                        <ul x-show="colunasOpen" x-transition
                            class="absolute top-full left-0 bg-white shadow-xl border-t-2 border-red-600 min-w-52 z-50">
                            @foreach ($catcolunas as $catc)
                                @if ($catc->posts->count() >= 1)
                                    <li class="border-b border-gray-100">
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
                                class="flex items-center gap-1 px-5 py-4 font-bold text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition h-full"
                                :class="regiaoOpen ? 'text-red-600 border-red-600' : ''">
                            REGIÃO <i class="fa fa-angle-down text-xs"></i>
                        </button>
                        <ul x-show="regiaoOpen" x-transition
                            class="absolute top-full left-0 bg-white shadow-xl border-t-2 border-red-600 min-w-52 z-50">
                            @foreach ($catnoticias as $catn)
                                @if ($catc->posts->count() >= 1)
                                    <li class="border-b border-gray-100">
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
                    class="flex items-center px-5 py-4 font-bold text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition">
                        WIKI UBATUBA
                    </a>
                </li>

            </ul>

            {{-- Search --}}
            <div class="flex items-center gap-3">
                <button @click="searchOpen = !searchOpen"
                        class="w-9 h-9 bg-red-600 text-white rounded flex items-center justify-center hover:bg-red-700 transition">
                    <i class="fa fa-search text-sm"></i>
                </button>
            </div>
        </div>

        {{-- Search bar --}}
        <div x-show="searchOpen" x-transition class="py-3 border-t">
            <form action="{{ route('web.pesquisa') }}" method="post">
                @csrf
                <div class="flex gap-2">
                    <input type="text" name="search" value="{{ $search ?? '' }}"
                        placeholder="Pesquisar..."
                        class="flex-1 border-2 border-gray-200 rounded px-4 py-2 text-sm focus:outline-none focus:border-red-500">
                    <button type="submit"
                            class="px-5 py-2 bg-red-600 text-white rounded text-sm font-bold hover:bg-red-700 transition">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- Mobile toggle --}}
        <div class="lg:hidden flex items-center justify-between py-2">
            <button @click="mobileOpen = !mobileOpen" class="p-2 text-gray-700 font-bold text-sm flex items-center gap-2">
                <i class="fa fa-bars"></i> MENU
            </button>
            <button @click="searchOpen = !searchOpen"
                    class="w-8 h-8 bg-red-600 text-white rounded flex items-center justify-center">
                <i class="fa fa-search text-xs"></i>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div x-show="mobileOpen" x-transition class="lg:hidden border-t">
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
                                class="flex items-center justify-between w-full px-4 py-3 font-bold text-sm text-gray-800">
                            COLUNAS <i class="fa fa-angle-down"></i>
                        </button>
                        <ul x-show="open" class="bg-gray-50">
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
                                class="flex items-center justify-between w-full px-4 py-3 font-bold text-sm text-gray-800">
                            REGIÃO <i class="fa fa-angle-down"></i>
                        </button>
                        <ul x-show="open" class="bg-gray-50">
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