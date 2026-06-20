<div class="w-full max-w-[728px] mx-auto overflow-hidden rounded-lg">
    @if($ad)
        <a href="{{ $ad->link }}" target="_blank" rel="noopener noreferrer">
            <img
                src="{{ asset('storage/' . $ad->image) }}"
                alt="{{ $ad->title }}"
                class="banner img-fluid"
            >
        </a>
    @else
        <a href="{{ route('web.anunciar') }}" target="_blank">
            <img
                src="{{ $plan?->getFallbackImageUrl() ?? asset('theme/images/banner728x90.jpg') }}"
                alt="Anuncie aqui"
                class="banner img-fluid"
            >
        </a>
    @endif
</div>