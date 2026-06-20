<div class="space-y-6">

    <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">

        {{-- Título + info --}}
        <div class="space-y-1">
            <h1 class="text-xl font-bold text-slate-800 md:text-2xl">
                Balneabilidade das praias em {{ Str::title(strtolower($cidade)) }}
            </h1>

            <p class="text-sm text-slate-500">
                Última atualização:
                <span class="font-medium text-slate-700">
                    {{ $ultimaAtualizacao ?? 'Sem dados' }}
                </span>
            </p>
        </div>

        {{-- Select --}}
        <div class="w-full md:w-auto">
            <select
                wire:model.live="cidade"
                class="w-full md:w-56 appearance-none rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 shadow-sm transition focus:border-sky-500 focus:ring-2 focus:ring-sky-200"
            >
                <option value="UBATUBA">🏖️ Ubatuba</option>
                <option value="SANTOS">🌊 Santos</option>
                <option value="CARAGUATATUBA">⛵ Caraguatatuba</option>
            </select>
        </div>

    </div>

    <div class="grid md:grid-cols-3 gap-4">

        @foreach ($praias as $praia)

            @php
                $propria = $praia['attributes']['classificacao_texto'] === 'Própria';
            @endphp

            <div class="p-4 rounded border
                {{ $praia['attributes']['classificacao_texto'] === 'Imprópria' ? 'bg-red-100 border-red-300' : 'bg-green-100 border-green-300' }}">

                <h3 class="font-semibold">
                    {{ Str::title(strtolower($praia['attributes']['praia'])) }}
                </h3>

                @if($propria)
                    <span class="inline-flex items-center gap-2 rounded-full bg-green-100 py-1 text-sm font-medium text-green-700">
                        <i class="fas fa-check-circle"></i>
                        Própria para banho
                    </span>
                @else
                    <span class="inline-flex items-center gap-2 rounded-full bg-red-100 py-1 text-sm font-medium text-red-700">
                        <i class="fas fa-times-circle"></i>
                        Imprópria para banho
                    </span>
                @endif

            </div>
        @endforeach

    </div>

</div>

@push('styles')
    <style>
        select {
            background-image: url("data:image/svg+xml,%3Csvg fill='none' stroke='currentColor' viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
            background-position: right 0.75rem center;
            background-repeat: no-repeat;
            background-size: 1rem;
        }
    </style>
@endpush