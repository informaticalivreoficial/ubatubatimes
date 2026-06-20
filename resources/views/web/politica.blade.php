@extends('web.master.master')

@section('content')

{{-- Breadcrumb --}}
<div class="border-b border-slate-200 bg-slate-50 py-4">
    <div class="mx-auto max-w-7xl px-4">
        <ul class="flex flex-wrap items-center gap-2 text-sm text-slate-600">
            <li>
                <a href="{{ route('web.home') }}" class="hover:text-red-600 transition">Início</a>
            </li>
            <li class="flex items-center gap-2">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400" aria-hidden="true"></i>
                <span class="text-slate-800 font-medium">Política de Privacidade</span>
            </li>
        </ul>
    </div>
</div>

<section class="py-10">
    <div class="mx-auto max-w-5xl px-4">
        <div class="prose prose-slate prose-lg max-w-none leading-relaxed text-slate-700">
            {!! $config->privacy_policy !!}
        </div>
    </div>
</section>

@endsection