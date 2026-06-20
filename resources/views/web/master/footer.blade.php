<footer id="footer" class="bg-slate-900 text-slate-300">
    <div class="mx-auto max-w-7xl px-4 py-12">
        <div class="grid grid-cols-1 gap-10 lg:grid-cols-3">

            {{-- Quem Somos --}}
            <div>
                <h3 class="mb-4 text-base font-bold uppercase tracking-wide text-white">
                    Quem Somos
                </h3>
                <ul class="flex flex-col gap-3 text-sm">
                    <li class="leading-relaxed text-slate-400">{{ $config->information }}</li>
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-house mt-0.5 text-slate-500" aria-hidden="true"></i>
                        <span>{{ $config->city }} - {{ $config->state }}</span>
                    </li>
                    @if ($config->phone)
                        <li class="flex items-center gap-2">
                            <i class="fas fa-phone text-slate-500" aria-hidden="true"></i>
                            <a href="tel:{{ $config->phone }}" class="hover:text-white transition">{{ $config->phone }}</a>
                        </li>
                    @endif
                    @if ($config->cell_phone)
                        <li class="flex items-center gap-2">
                            <i class="fas fa-phone text-slate-500" aria-hidden="true"></i>
                            <a href="tel:{{ $config->cell_phone }}" class="hover:text-white transition">{{ $config->cell_phone }}</a>
                        </li>
                    @endif
                    @if ($config->whatsapp)
                        <li class="flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-slate-500" aria-hidden="true"></i>
                            <a target="_blank" rel="noopener"
                               href="{{ \App\Helpers\WhatsApp::getNumZap($config->whatsapp, $config->app_name) }}"
                               class="hover:text-white transition">
                                {{ $config->whatsapp }}
                            </a>
                        </li>
                    @endif
                    @if ($config->email)
                        <li class="flex items-center gap-2">
                            <i class="fa-regular fa-envelope text-slate-500" aria-hidden="true"></i>
                            <a href="mailto:{{ $config->email }}" class="hover:text-white transition break-all">{{ $config->email }}</a>
                        </li>
                    @endif
                    @if ($config->additional_email)
                        <li class="flex items-center gap-2">
                            <i class="fa-regular fa-envelope text-slate-500" aria-hidden="true"></i>
                            <a href="mailto:{{ $config->additional_email }}" class="hover:text-white transition break-all">{{ $config->additional_email }}</a>
                        </li>
                    @endif
                </ul>

                {{-- Redes sociais --}}
                <ul class="mt-6 flex items-center gap-3">
                    @if ($config->facebook)
                        <li>
                            <a target="_blank" rel="noopener" href="{{ $config->facebook }}" title="Facebook"
                               class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-800 text-slate-300 transition hover:bg-blue-600 hover:text-white">
                                <i class="fa-brands fa-facebook" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                    @if ($config->twitter)
                        <li>
                            <a target="_blank" rel="noopener" href="{{ $config->twitter }}" title="Twitter"
                               class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-800 text-slate-300 transition hover:bg-sky-500 hover:text-white">
                                <i class="fa-brands fa-twitter" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                    @if ($config->instagram)
                        <li>
                            <a target="_blank" rel="noopener" href="{{ $config->instagram }}" title="Instagram"
                               class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-800 text-slate-300 transition hover:bg-pink-600 hover:text-white">
                                <i class="fa-brands fa-instagram" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                    @if ($config->linkedin)
                        <li>
                            <a target="_blank" rel="noopener" href="{{ $config->linkedin }}" title="LinkedIn"
                               class="flex h-9 w-9 items-center justify-center rounded-full bg-slate-800 text-slate-300 transition hover:bg-blue-700 hover:text-white">
                                <i class="fa-brands fa-linkedin" aria-hidden="true"></i>
                            </a>
                        </li>
                    @endif
                </ul>
            </div>

            {{-- Links úteis --}}
            <div>
                <h3 class="mb-4 text-base font-bold uppercase tracking-wide text-white">
                    Links úteis
                </h3>
                <ul class="flex flex-col gap-2.5 text-sm">
                    <li>
                        <a href="{{ route('web.guiaUbatuba') }}" class="flex items-center gap-2 text-slate-400 transition hover:text-white">
                            <i class="fa fa-angle-double-right text-xs" aria-hidden="true"></i> Guia Comercial Ubatuba
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.anunciar') }}" target="_blank" rel="noopener" class="flex items-center gap-2 text-slate-400 transition hover:text-white">
                            <i class="fa fa-angle-double-right text-xs" aria-hidden="true"></i> Anunciar
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.blog.artigos') }}" class="flex items-center gap-2 text-slate-400 transition hover:text-white">
                            <i class="fa fa-angle-double-right text-xs" aria-hidden="true"></i> Blog
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.pesquisa') }}" class="flex items-center gap-2 text-slate-400 transition hover:text-white">
                            <i class="fa fa-angle-double-right text-xs" aria-hidden="true"></i> Pesquisar no site
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.noticias') }}" class="flex items-center gap-2 text-slate-400 transition hover:text-white">
                            <i class="fa fa-angle-double-right text-xs" aria-hidden="true"></i> Notícias
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.ondas') }}" class="flex items-center gap-2 text-slate-400 transition hover:text-white">
                            <i class="fa fa-angle-double-right text-xs" aria-hidden="true"></i> Boletim das Ondas
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.tempo') }}" class="flex items-center gap-2 text-slate-400 transition hover:text-white">
                            <i class="fa fa-angle-double-right text-xs" aria-hidden="true"></i> Previsão do Tempo
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.blog.categoria', ['slug' => 'praias-de-ubatuba']) }}" class="flex items-center gap-2 text-slate-400 transition hover:text-white">
                            <i class="fa fa-angle-double-right text-xs" aria-hidden="true"></i> Praias de Ubatuba
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.blog.categoria', ['slug' => 'wiki-ubatuba']) }}" class="flex items-center gap-2 text-slate-400 transition hover:text-white">
                            <i class="fa fa-angle-double-right text-xs" aria-hidden="true"></i> Wiki Ubatuba
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('web.politica') }}" class="flex items-center gap-2 text-slate-400 transition hover:text-white">
                            <i class="fa fa-angle-double-right text-xs" aria-hidden="true"></i> Política de Privacidade
                        </a>
                    </li>
                    <li>
                        <button type="button" @click="openModal()" class="flex items-center gap-2 text-slate-400 transition hover:text-teal-400">
                            <i class="fa fa-angle-double-right text-xs" aria-hidden="true"></i> Preferências de cookies
                        </button>
                    </li>
                </ul>
            </div>

            {{-- Instagram Posts --}}
            <div>
                <h3 class="mb-4 text-base font-bold uppercase tracking-wide text-white">
                    Instagram Posts
                </h3>
            </div>

        </div>
    </div>
</footer>