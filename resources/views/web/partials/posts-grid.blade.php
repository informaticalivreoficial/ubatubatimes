@foreach ($posts as $post)
    <article class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm transition hover:shadow-md">
        <a href="{{ route($post->type == 'artigo' ? 'web.blog.artigo' : 'web.noticia', ['slug' => $post->slug]) }}" class="block">
            <img src="{{ $post->cover() }}" alt="{{ $post->title }}"
                 class="h-[270px] w-full object-cover">
        </a>
        <div class="p-4">
            @if ($post->categoryObject)
                <a href="{{ route('web.blog.categoria', ['slug' => $post->categoryObject->slug]) }}"
                   class="inline-block rounded bg-red-50 px-2 py-0.5 text-xs font-semibold uppercase tracking-wide text-red-600 hover:bg-red-100">
                    {{ $post->categoryObject->title }}
                </a>
            @endif
            <h2 class="mt-2 text-base font-bold leading-snug text-slate-900">
                <a href="{{ route($post->type == 'artigo' ? 'web.blog.artigo' : 'web.noticia', ['slug' => $post->slug]) }}" class="hover:text-red-600">
                    {{ $post->title }}
                </a>
            </h2>
            <div class="mt-3 flex items-center gap-4 text-xs text-slate-500">
                <span class="flex items-center gap-1">
                    <i class="fa-solid fa-eye" aria-hidden="true"></i> {{ $post->views }}
                </span>
                <span class="flex items-center gap-1">
                    <i class="fa-regular fa-clock" aria-hidden="true"></i>
                    {{ \Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}
                </span>
            </div>
            <p class="mt-3 text-sm leading-relaxed text-slate-600">
                {!! Words($post->content, 21) !!}
            </p>
        </div>
    </article>
@endforeach