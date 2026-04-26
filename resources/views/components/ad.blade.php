<div>
    @if($ad)
        <a href="{{ $ad->link }}" target="_blank">
            <img 
                src="{{ asset('storage/' . $ad->image) }}" 
                alt="{{ $ad->title }}"
                class="w-full h-auto"
            >
        </a>
    @else
        <a href="{{route('web.anunciar')}}" target="_blank">
            <img src="{{url(asset('theme/images/banner728x90.jpg'))}}" class="img-fluid" alt="Anuncie Aqui!">
        </a>
    @endif
</div>