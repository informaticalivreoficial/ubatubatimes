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
                <a href="{{ route('web.guiaUbatuba') }}" class="hover:text-red-600 transition">Guia</a>
            </li>
            <li class="flex items-center gap-2">
                <i class="fa-solid fa-chevron-right text-xs text-slate-400" aria-hidden="true"></i>
                <span class="text-slate-800 font-medium">{{ $categoria->title }}</span>
            </li>
        </ul>
    </div>
</div>

<livewire:web.guia-categoria :slug="$categoria->slug" />

@endsection
