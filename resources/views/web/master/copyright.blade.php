<div class="bg-slate-950 py-6">
    <div class="mx-auto max-w-7xl px-4">
        <div class="flex flex-col items-center gap-2 text-center">
            <span class="text-sm text-slate-400">
                © {{ $config->init_date }} Copyright {{ $config->app_name }}. Todos os direitos reservados.
            </span>
            <p class="text-sm text-slate-400">
                Feito com <i class="fa-solid fa-heart text-red-500" aria-hidden="true"></i> por
                <a target="_blank" rel="noopener" href="{{ config('app.desenvolvedor_url') }}" class="text-white hover:text-slate-200 transition">
                    {{ config('app.desenvolvedor') }}
                </a>
            </p>
        </div>

        <button id="back-to-top"
                type="button"
                title="Voltar ao topo"
                aria-label="Voltar ao topo"
                class="fixed bottom-6 right-6 z-50 hidden h-11 w-11 items-center justify-center rounded-full bg-red-600 text-white shadow-lg transition hover:bg-red-700">
            <i class="fa-solid fa-angle-up" aria-hidden="true"></i>
        </button>
    </div>
</div>