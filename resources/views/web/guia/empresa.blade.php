@extends('web.master.master')


@section('content')

 <!-- Compartilhar -->
@php
    $url = urlencode(request()->fullUrl());
    $title = urlencode($empresa->title);
@endphp

<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb text-sm text-gray-500 flex gap-2 flex-wrap">
                    <li><a href="{{ route('web.home') }}">Início</a></li>                    
                    <li><a href="{{ route('web.guiaUbatuba') }}">Guia</a></li>

                    @if($empresa->categoriaObject)                        
                        <li>
                            <a href="{{ route('web.guiaCategoria', $empresa->categoriaObject->slug) }}">
                                {{ $empresa->categoriaObject->title }}
                            </a>
                        </li>
                    @endif

                    @if($empresa->subcategoriaObject)                        
                        <li>
                            <a href="{{ route('web.guiaSubCategoria', $empresa->subcategoriaObject->slug) }}">
                                {{ $empresa->subcategoriaObject->title }}
                            </a>
                        </li>
                    @endif
                    
                    <li class="text-gray-700">{{ $empresa->alias_name }}</li>
                </ul>
            </div>
        </div>
    </div>
</div>    
  
  <section class="utf_block_wrapper">
    <div class="container">
      <div class="row">
                
          <div class="col-lg-4 col-md-12">
              <div class="sidebar utf_sidebar_right">

                  <div class="widget text-center"> 
                      <img class="banner img-fluid" src="{{$empresa->getlogo()}}" alt="{{$empresa->alias_name}}" /> 
                  </div>

                  <div class="widget color-red">
                      <h3 class="utf_block_title"><span>Atendimento</span></h3>
                      <div class="utf_list_post_block">
                        <div class="text-sm space-y-1">
                            @if ($empresa->email)
                                <p><b>Email:</b> <a href="mailto:{{ $empresa->email }}">{{ $empresa->email }}</a></p>
                            @endif

                            @if ($empresa->telefone)
                                <p><b>Telefone:</b> <a href="tel:{{ $empresa->telefone }}">{{ $empresa->telefone }}</a></p>
                            @endif

                            @if ($empresa->whatsapp)
                                <p><b>WhatsApp:</b> <a href="{{ getNumZap($empresa->whatsapp, $empresa->alias_name) }}" target="_blank">{{ $empresa->whatsapp }}</a></p>
                            @endif
                        </div>
                      </div>
                  </div>
                  
                  <div class="widget color-red">
                      <div class="flex gap-3 text-xl">
                        @foreach([
                            'facebook' => 'fa-facebook',
                            'instagram' => 'fa-instagram',
                            'linkedin' => 'fa-linkedin',
                            'twitter' => 'fa-twitter',
                        ] as $field => $icon)

                            @if($empresa->$field)
                                <a href="{{ $empresa->$field }}" target="_blank">
                                    <i class="fa {{ $icon }}"></i>
                                </a>
                            @endif

                        @endforeach
                    </div>
                  </div>

                  <div class="widget color-red">
                      {!!$empresa->maps!!}
                  </div>

              </div>
          </div>
          
          <div class="col-lg-8 col-md-12">
            <div class="single-post">
                  <div class="utf_post_title-area"> 
                      <a class="utf_post_cat" href="{{route('web.guiaSubCategoria', [ 'slug' => $empresa->categoriaObject->slug ])}}">{{$empresa->categoriaObject->title}}</a>
                      <h2 class="utf_post_title">{{$empresa->alias_name}}</h2>
                      <div class="utf_post_meta"> 
                          <span class="post-hits"><i class="fa fa-eye"></i> {{$empresa->views}}</span> 
                      </div>
                  </div>
              
                  <div class="utf_post_content-area">              
                      <div class="entry-content">
                            {!!$empresa->content!!}

                            @if($empresa->metatags)
                                <div class="flex flex-wrap gap-2 mt-4">
                                    @foreach($empresa->metatags_array as $tag)
                                        <span class="text-xs bg-gray-100 px-2 py-1 rounded">
                                            #{{ trim($tag) }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <h3 class="text-xl font-semibold text-gray-900 mb-6">
                                Compartilhe
                            </h3>
                            <div class="flex flex-wrap gap-3">

                                <!-- Facebook -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $url }}"
                                target="_blank"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-[#1877F2] text-white hover:scale-110 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M22 12a10 10 0 10-11.63 9.87v-6.99h-2.8V12h2.8V9.8c0-2.76 1.64-4.3 4.15-4.3 1.2 0 2.45.21 2.45.21v2.7h-1.38c-1.36 0-1.78.84-1.78 1.7V12h3.03l-.48 2.88h-2.55v6.99A10 10 0 0022 12z"/>
                                    </svg>
                                </a>

                                <!-- X -->
                                <a href="https://twitter.com/intent/tweet?text={{ $title }}&url={{ $url }}"
                                target="_blank"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-black text-white hover:scale-110 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M18.244 2H21l-6.563 7.502L22 22h-6.828l-5.341-7.03L3.463 22H1l7.02-8.02L2 2h6.91l4.825 6.37L18.244 2z"/>
                                    </svg>
                                </a>

                                {{-- WhatsApp --}}
                                <a href="#"
                                onclick="shareWhatsApp(event)"
                                target="_blank"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-[#25D366] text-white hover:scale-110 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M20.52 3.48A11.93 11.93 0 0012.04 0C5.43 0 .1 5.33.1 11.94c0 2.1.55 4.15 1.6 5.96L0 24l6.27-1.64a11.92 11.92 0 005.77 1.47h.01c6.61 0 11.94-5.33 11.94-11.94 0-3.19-1.24-6.19-3.47-8.41zM12.05 21.8h-.01a9.87 9.87 0 01-5.02-1.37l-.36-.21-3.72.97.99-3.63-.23-.37a9.87 9.87 0 01-1.51-5.24c0-5.46 4.45-9.9 9.91-9.9 2.65 0 5.14 1.03 7.01 2.91a9.84 9.84 0 012.89 7c0 5.46-4.45 9.9-9.91 9.9zm5.44-7.37c-.3-.15-1.76-.87-2.03-.97-.27-.1-.46-.15-.65.15-.2.3-.75.97-.92 1.17-.17.2-.34.22-.64.07-.3-.15-1.26-.46-2.4-1.46-.88-.79-1.48-1.76-1.66-2.06-.17-.3-.02-.46.13-.61.13-.13.3-.34.45-.5.15-.17.2-.3.3-.5.1-.2.05-.37-.02-.52-.07-.15-.65-1.57-.9-2.15-.24-.57-.49-.5-.65-.51h-.55c-.2 0-.52.07-.8.37-.27.3-1.04 1.02-1.04 2.48 0 1.46 1.06 2.87 1.21 3.07.15.2 2.08 3.17 5.05 4.45.7.3 1.25.48 1.68.62.7.22 1.33.19 1.83.12.56-.08 1.76-.72 2.01-1.41.25-.7.25-1.3.17-1.41-.07-.1-.27-.17-.57-.32z"/>
                                    </svg>
                                </a>

                                <!-- LinkedIn -->
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $url }}"
                                target="_blank"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-[#0A66C2] text-white hover:scale-110 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M4.98 3.5C4.98 4.88 3.86 6 2.49 6S0 4.88 0 3.5 1.12 1 2.49 1s2.49 1.12 2.49 2.5zM0 8h5v16H0V8zm7.5 0h4.78v2.16h.07c.67-1.27 2.3-2.6 4.73-2.6 5.06 0 6 3.33 6 7.66V24h-5v-7.84c0-1.87-.03-4.28-2.61-4.28-2.61 0-3.01 2.04-3.01 4.15V24h-5V8z"/>
                                    </svg>
                                </a>

                                <!-- Telegram -->
                                <a href="https://t.me/share/url?url={{ $url }}&text={{ $title }}"
                                target="_blank"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-[#229ED9] text-white hover:scale-110 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M9.993 15.674l-.4 4.326c.573 0 .822-.246 1.123-.54l2.694-2.577 5.586 4.09c1.024.563 1.75.267 2.004-.95l3.63-17.037c.337-1.56-.563-2.17-1.558-1.8L1.357 9.63c-1.516.592-1.495 1.44-.258 1.823l5.66 1.77 13.148-8.29c.62-.41 1.184-.183.72.227"/>
                                    </svg>
                                </a>

                                <!-- Email -->
                                <a href="mailto:?subject={{ $title }}&body={{ $url }}"
                                class="w-10 h-10 flex items-center justify-center rounded-full bg-gray-600 text-white hover:scale-110 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                        <path d="M12 13.065L.015 4.5A2 2 0 012 3h20a2 2 0 011.985 1.5L12 13.065zM0 6.697V19a2 2 0 002 2h20a2 2 0 002-2V6.697l-12 8.25L0 6.697z"/>
                                    </svg>
                                </a>

                            </div>

                            @if($empresa->images->isNotEmpty())
                                <div class="grid grid-cols-3 gap-3 mt-4">
                                    @foreach($empresa->images->where('cover', false) as $image)
                                        @if(!$image->cover)
                                            <a href="{{ $image->url_image }}" class="glightbox block" data-gallery="empresa">
                                                <img 
                                                    src="{{ $image->url_cropped }}"
                                                    class="w-full h-32 object-cover rounded"
                                                >
                                            </a>
                                        @endif
                                    @endforeach
                                </div>
                            @endif
                      </div>                                  
                  </div>
            </div>
            
            @if ($empresa->email)
                <livewire:web.email.contact-company-form :empresa="$empresa" />
            @endif
                   
        </div>
        
        
      </div>

        @if($empresas->isNotEmpty() && !$empresa->client)
            <div class="mt-10">
                <h3 class="text-lg font-semibold mb-4">Veja também</h3>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($empresas as $item)
                        <a href="{{ route('web.guiaEmpresa', $item->slug) }}" class="block text-center hover:scale-105 transition">
                            <img 
                                src="{{ $item->getlogo() }}" 
                                class="mx-auto max-w-[120px] object-contain"
                            >
                            <p class="text-sm mt-2">{{ $item->alias_name }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
        

    </div>
  </section>

@endsection

@section('css')
    <style>
        iframe{
          width: 100%; 
          min-height: 400px;
        }        
    </style>
@endsection

@section('js')
    <script>
        const lightbox = GLightbox({
            selector: '.glightbox'
        });

        function shareWhatsApp(event) {
            event.preventDefault();

            const url = encodeURIComponent(window.location.href);
            const text = encodeURIComponent(document.title);
            const message = text + " " + url;

            const isMobile = /Android|iPhone|iPad|iPod|Opera Mini|IEMobile|WPDesktop/i.test(navigator.userAgent);

            const whatsappUrl = isMobile
                ? `https://api.whatsapp.com/send?text={{ $title }}%20{{ $url }}`
                : `https://web.whatsapp.com/send?text={{ $title }}%20{{ $url }}`;

            window.open(whatsappUrl, '_blank');
        }
    </script>
@endsection