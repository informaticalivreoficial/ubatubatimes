<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#ec0000">
	<meta name="msvalidate.01" content="AB238289F13C246C5E386B6770D9F10E" />

    <meta name="copyright" content="{{$config->init_date}} - {{$config->app_name}}">
    <meta name="language" content="pt-br" /> 
    <meta name="author" content="{{config('app.desenvolvedor')}}"/>
    <meta name="designer" content="Renato Montanari">
    <meta name="publisher" content="Renato Montanari">
    <meta name="url" content="{{$config->domain}}" />
    <meta name="keywords" content="{{$config->metatags}}">
    <meta name="distribution" content="web">
    <meta name="rating" content="general">
    <meta name="date" content="Dec 26">

    {!! $head ?? '' !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- STYLE  -->
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />

	<link rel="stylesheet" type="text/css" href="{{url(asset('frontend/assets/css/bootstrap.min.css'))}}" >
	<link rel="stylesheet" type="text/css" href="{{url(asset('frontend/assets/css/style.css'))}}">
	<link rel="stylesheet" type="text/css" href="{{url(asset('frontend/assets/css/responsive.css'))}}">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="{{url(asset('frontend/assets/css/owl.carousel.min.css'))}}">
	<link rel="stylesheet" type="text/css" href="{{url(asset('frontend/assets/css/owl.theme.default.min.css'))}}">
	<link rel="stylesheet" type="text/css" href="{{url(asset('frontend/assets/css/colorbox.css'))}}">
	<link rel="stylesheet" type="text/css" href="{{url(asset('frontend/assets/css/renato.css'))}}">	

	<!-- Google Fonts --> 
	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,500,600,700,800&display=swap" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700,800&display=swap" rel="stylesheet">

	<!-- Favicon and touch icons  -->
	<link href="{{$config->getfaveicon()}}" rel="apple-touch-icon-precomposed" sizes="144x144">
	<link href="{{$config->getfaveicon()}}" rel="apple-touch-icon-precomposed" sizes="114x114">
	<link href="{{$config->getfaveicon()}}" rel="apple-touch-icon-precomposed" sizes="72x72">
	<link href="{{$config->getfaveicon()}}" rel="apple-touch-icon-precomposed">
	<link href="{{$config->getfaveicon()}}" rel="shortcut icon">

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
    @hasSection('css')
        @yield('css')
    @endif

	<style>
        [x-cloak] { display: none !important; }
    </style>

    @stack('styles')

	@vite(['resources/css/app.css', 'resources/js/front.js'])
	
</head>

<body x-data="cookieConsent">
	<div class="body-inner">		
		{{-- HEADER --}}
		@include('web.master.header')

		{{-- MAIN NAV --}}
		@include('web.master.main-nav')

		@yield('content')

		{{-- FOOTER --}}
    	@include('web.master.footer')		
		
		{{-- COPYRIGHT --}}
		@include('web.master.copyright')
	</div>

	{{-- BANNER --}}
    <div 
        x-cloak
        x-show="!accepted"
        class="fixed bottom-0 left-0 right-0 bg-gray-900 text-white p-4 z-40"
    >
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <p>
                Utilizamos cookies para melhorar sua experiência.
            </p>

            <div class="flex gap-3">
                <button @click="acceptAll()" class="bg-green-600 px-4 py-2 rounded">
                    Aceitar todos
                </button>

                <button @click="openModal()" class="bg-gray-600 px-4 py-2 rounded">
                    Preferências
                </button>
            </div>
        </div>
    </div>

	{{-- MODAL --}}
    <div 
        x-cloak
        x-show="open"
        x-transition
        class="fixed inset-0 bg-black/50 flex items-center justify-center z-50"
        @click.self="closeModal()"
    >
        <div class="bg-white text-black p-6 rounded w-96 relative">
            
            <button 
                @click="closeModal()" 
                class="absolute top-2 right-2 text-gray-500"
            >
                ✕
            </button>

            <h2 class="text-lg font-bold mb-4">Preferências de Cookies</h2>

            <label class="block mb-2">
                <input type="checkbox" checked disabled>
                Essenciais
            </label>

            <label class="block mb-2">
                <input type="checkbox" x-model="stats">
                Estatísticos
            </label>

            <label class="block mb-4">
                <input type="checkbox" x-model="marketing">
                Marketing
            </label>

            <button 
                @click="save()" 
                class="bg-blue-600 text-white px-4 py-2 rounded w-full"
            >
                Salvar preferências
            </button>
        </div>
    </div>  

	<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

	<script type="text/javascript" src="{{url(asset('frontend/assets/js/jquery.min.js'))}}"></script>
	<script type="text/javascript" src="{{url(asset('frontend/assets/js/popper.min.js'))}}"></script>
	<script type="text/javascript" src="{{url(asset('frontend/assets/js/bootstrap.min.js'))}}"></script>
	<script type="text/javascript" src="{{url(asset('frontend/assets/js/jquery.colorbox.js'))}}"></script>	
	<script type="text/javascript" src="{{url(asset('frontend/assets/js/custom_script.js'))}}"></script>

	@hasSection('js')
        @yield('js')
    @endif

    <script>
        (function () {
            var backToTop = document.getElementById('back-to-top');
            if (!backToTop) return;

            window.addEventListener('scroll', function () {
                if (window.scrollY > 400) {
                    backToTop.classList.remove('hidden');
                    backToTop.classList.add('flex');
                } else {
                    backToTop.classList.add('hidden');
                    backToTop.classList.remove('flex');
                }
            });

            backToTop.addEventListener('click', function () {
                window.scrollTo({ top: 0, behavior: 'smooth' });
            });
        })();
    </script>

    <!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-HQ3MRW6582"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());

		gtag('config', 'G-HQ3MRW6582');
	</script>

	@livewireScripts
</body>
</html>