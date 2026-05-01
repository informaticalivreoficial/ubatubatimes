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
	<link rel="stylesheet" type="text/css" href="{{url(asset('frontend/assets/css/font-awesome.min.css'))}}">
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

	@vite(['resources/css/app.css', 'resources/js/app.js'])
	
</head>

<body>
	<div class="body-inner">
		
		<div id="top-bar" class="top-bar">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<ul class="unstyled top-nav">
							<li><a href="{{route('web.ondas')}}">Boletim das Ondas</a></li>
							<li><a href="{{route('web.tempo')}}">Previsão do Tempo</a></li>
						</ul>
					</div>
					<div class="col-md-4 top-social text-lg-right text-md-center">
						@php
							// PEGA COTAÇÃO DO DOLAR VIA JSON
							$url = @file_get_contents('https://economia.awesomeapi.com.br/json/USD-BRL/1');
							if ($url !== false && !empty($url)) {
								$json = json_decode($url, true);
								$imprime = end($json);
								$cor = ($imprime['pctChange'] < '0' ? 'pos' :
									($imprime['pctChange'] == '0' ? 'neutro' : 
									($imprime['pctChange'] > '0' ? 'neg' : 'neg')));
								$sinal = ($imprime['pctChange'] < '0' ? '' :
									($imprime['pctChange'] == '0' ? '' : 
									($imprime['pctChange'] > '0' ? '+' : '+')));
								echo '<div class="numbers">';                    
								echo '<span class="value bra"> '.$imprime['name'].' R$'.number_format($imprime['ask'],'3',',','').'</span>';
								echo '<span class="data '.$cor.'">'.$sinal.' '.number_format($imprime['pctChange'],'2',',','').'% </span>';
								echo '</div>';
							}							
						@endphp
					</div>
				</div>
			</div>
		</div>
		
		<header id="header" class="header">
			<div class="container">
				<div class="row">
					<div class="col-md-3 col-sm-12">
						<div class="logo"> 
							<a href="{{route('web.home')}}"> 
								<img src="{{$config->getlogo()}}" alt="{{$config->app_name}}"> 
							</a> 
						</div>
					</div>   
					<div class="col-md-9 col-sm-12 header-right">
						<div class="float-right mt-3"> 
							<x-ad slot="home_top" />
						</div>												
					</div>
				</div>
			</div>
		</header>
		<!-- Header End -->
		
		<!-- Main Nav Start --> 
		<div x-data="{ mobileOpen: false, colunasOpen: false, regiaoOpen: false, searchOpen: false }"
			class="bg-white sticky top-0 z-50 shadow-sm">
			<div class="container mx-auto px-4">

				{{-- Desktop --}}
				<div class="hidden lg:flex items-center justify-between">
					<ul class="flex items-stretch">

						{{-- GUIA --}}
						<li>
							<a href="{{ route('web.guiaUbatuba') }}"
							class="flex items-center px-5 py-4 bg-yellow-400 font-black text-sm tracking-wide hover:bg-yellow-500 transition">
								GUIA
							</a>
						</li>

						{{-- PRAIAS DE UBATUBA --}}
						<li>
							<a href="{{ route('web.blog.categoria', ['slug' => 'praias-de-ubatuba']) }}"
							class="flex items-center px-5 py-4 font-bold text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition">
								PRAIAS DE UBATUBA
							</a>
						</li>

						{{-- BLOG --}}
						<li>
							<a href="{{ route('web.blog.artigos') }}"
							class="flex items-center px-5 py-4 font-bold text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition">
								BLOG
							</a>
						</li>

						{{-- COLUNAS --}}
						@if ($catcolunas && $catcolunas->count() > 0)
							<li class="relative" @click.outside="colunasOpen = false">
								<button @click="colunasOpen = !colunasOpen"
										class="flex items-center gap-1 px-5 py-4 font-bold text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition h-full"
										:class="colunasOpen ? 'text-red-600 border-red-600' : ''">
									COLUNAS <i class="fa fa-angle-down text-xs"></i>
								</button>
								<ul x-show="colunasOpen" x-transition
									class="absolute top-full left-0 bg-white shadow-xl border-t-2 border-red-600 min-w-52 z-50">
									@foreach ($catcolunas as $catc)
										@if ($catc->posts->count() >= 1)
											<li class="border-b border-gray-100">
												<a href="{{ route('web.blog.categoria', ['slug' => $catc->slug]) }}"
												class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:text-red-600 hover:bg-gray-50 transition">
													<span class="text-red-500">»</span> {{ $catc->title }}
												</a>
											</li>
										@endif
									@endforeach
								</ul>
							</li>
						@endif

						{{-- REGIÃO --}}
						@if ($catnoticias && $catnoticias->count() > 0)
							<li class="relative" @click.outside="regiaoOpen = false">
								<button @click="regiaoOpen = !regiaoOpen"
										class="flex items-center gap-1 px-5 py-4 font-bold text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition h-full"
										:class="regiaoOpen ? 'text-red-600 border-red-600' : ''">
									REGIÃO <i class="fa fa-angle-down text-xs"></i>
								</button>
								<ul x-show="regiaoOpen" x-transition
									class="absolute top-full left-0 bg-white shadow-xl border-t-2 border-red-600 min-w-52 z-50">
									@foreach ($catnoticias as $catn)
										@if ($catc->posts->count() >= 1)
											<li class="border-b border-gray-100">
												<a href="{{ route('web.noticia.categoria', ['slug' => $catn->slug]) }}"
												class="flex items-center gap-2 px-4 py-3 text-sm text-gray-700 hover:text-red-600 hover:bg-gray-50 transition">
													<span class="text-red-500">»</span> {{ $catn->title }}
												</a>
											</li>
										@endif
									@endforeach
								</ul>
							</li>
						@endif

						{{-- WIKI UBATUBA --}}
						<li>
							<a href="{{ route('web.blog.categoria', ['slug' => 'wiki-ubatuba']) }}"
							class="flex items-center px-5 py-4 font-bold text-sm tracking-wide text-gray-800 hover:text-red-600 border-b-4 border-transparent hover:border-red-600 transition">
								WIKI UBATUBA
							</a>
						</li>

					</ul>

					{{-- Search --}}
					<div class="flex items-center gap-3">
						<button @click="searchOpen = !searchOpen"
								class="w-9 h-9 bg-red-600 text-white rounded flex items-center justify-center hover:bg-red-700 transition">
							<i class="fa fa-search text-sm"></i>
						</button>
					</div>
				</div>

				{{-- Search bar --}}
				<div x-show="searchOpen" x-transition class="py-3 border-t">
					<form action="{{ route('web.pesquisa') }}" method="post">
						@csrf
						<div class="flex gap-2">
							<input type="text" name="search" value="{{ $search ?? '' }}"
								placeholder="Pesquisar..."
								class="flex-1 border-2 border-gray-200 rounded px-4 py-2 text-sm focus:outline-none focus:border-red-500">
							<button type="submit"
									class="px-5 py-2 bg-red-600 text-white rounded text-sm font-bold hover:bg-red-700 transition">
								<i class="fa fa-search"></i>
							</button>
						</div>
					</form>
				</div>

				{{-- Mobile toggle --}}
				<div class="lg:hidden flex items-center justify-between py-2">
					<button @click="mobileOpen = !mobileOpen" class="p-2 text-gray-700 font-bold text-sm flex items-center gap-2">
						<i class="fa fa-bars"></i> MENU
					</button>
					<button @click="searchOpen = !searchOpen"
							class="w-8 h-8 bg-red-600 text-white rounded flex items-center justify-center">
						<i class="fa fa-search text-xs"></i>
					</button>
				</div>

				{{-- Mobile menu --}}
				<div x-show="mobileOpen" x-transition class="lg:hidden border-t">
					<ul>
						<li>
							<a href="{{ route('web.guiaUbatuba') }}"
							class="flex items-center px-4 py-3 bg-yellow-400 font-black text-sm tracking-wide">
								GUIA
							</a>
						</li>
						<li class="border-b">
							<a href="{{ route('web.blog.categoria', ['slug' => 'praias-de-ubatuba']) }}"
							class="block px-4 py-3 font-bold text-sm text-gray-800">PRAIAS DE UBATUBA</a>
						</li>
						<li class="border-b">
							<a href="{{ route('web.blog.artigos') }}"
							class="block px-4 py-3 font-bold text-sm text-gray-800">BLOG</a>
						</li>

						@if ($catcolunas && $catcolunas->count() > 0)
							<li x-data="{ open: false }" class="border-b">
								<button @click="open = !open"
										class="flex items-center justify-between w-full px-4 py-3 font-bold text-sm text-gray-800">
									COLUNAS <i class="fa fa-angle-down"></i>
								</button>
								<ul x-show="open" class="bg-gray-50">
									@foreach ($catcolunas as $catc)
										@if ($catc->posts->count() >= 1)
											<li class="border-t border-gray-100">
												<a href="{{ route('web.blog.categoria', ['slug' => $catc->slug]) }}"
												class="flex items-center gap-2 px-6 py-2 text-sm text-gray-700">
													<span class="text-red-500">»</span> {{ $catc->title }}
												</a>
											</li>
										@endif
									@endforeach
								</ul>
							</li>
						@endif

						@if ($catnoticias && $catnoticias->count() > 0)
							<li x-data="{ open: false }" class="border-b">
								<button @click="open = !open"
										class="flex items-center justify-between w-full px-4 py-3 font-bold text-sm text-gray-800">
									REGIÃO <i class="fa fa-angle-down"></i>
								</button>
								<ul x-show="open" class="bg-gray-50">
									@foreach ($catnoticias as $catn)
										@if ($catn->posts->count() >= 1)
											<li class="border-t border-gray-100">
												<a href="{{ route('web.noticia.categoria', ['slug' => $catn->slug]) }}"
												class="flex items-center gap-2 px-6 py-2 text-sm text-gray-700">
													<span class="text-red-500">»</span> {{ $catn->title }}
												</a>
											</li>
										@endif
									@endforeach
								</ul>
							</li>
						@endif

						<li class="border-b">
							<a href="{{ route('web.blog.categoria', ['slug' => 'wiki-ubatuba']) }}"
							class="block px-4 py-3 font-bold text-sm text-gray-800">WIKI UBATUBA</a>
						</li>
					</ul>
				</div>

			</div>
		</div>


		@yield('content')

		<!-- Footer -->
		<footer id="footer" class="footer">
			<div class="utf_footer_main">
			<div class="container">
				<div class="row">
					<div class="col-lg-4 col-sm-12 col-xs-12 footer-widget contact-widget">
							<h3 class="widget-title">Quem Somos</h3>
							<ul>
								<li>{{$config->information}}</li>
								<li><i class="fa fa-home"></i> {{$config->city}} - {{$config->state}}</li>
								@if ($config->phone)
									<li><i class="fa fa-phone"></i> <a href="tel:{{$config->phone}}">{{$config->phone}}</a></li>
								@endif
								@if ($config->cell_phone)
									<li><i class="fa fa-phone"></i> <a href="tel:{{$config->cell_phone}}">{{$config->cell_phone}}</a></li>
								@endif
								@if ($config->whatsapp)
									<li><i class="fa fa-whatsapp"></i> <a target="_blank" href="{{\App\Helpers\WhatsApp::getNumZap($config->whatsapp ,$config->app_name)}}">{{$config->whatsapp}}</a></li>
								@endif								
								@if ($config->email)
									<li><i class="fa fa-envelope-o"></i> <a href="mailto:{{$config->email}}">{{$config->email}}</a></li>
								@endif
								@if ($config->additional_email)
									<li><i class="fa fa-envelope-o"></i> <a href="mailto:{{$config->additional_email}}">{{$config->additional_email}}</a></li>
								@endif											 
							</ul>
							<ul class="unstyled utf_footer_social">
								@if ($config->facebook)
									<li><a target="_blank" href="{{$config->facebook}}" title="Facebook"><i class="fa fa-facebook"></i></a></li>
								@endif
								@if ($config->twitter)
									<li><a target="_blank" href="{{$config->twitter}}" title="Twitter"><i class="fa fa-twitter"></i></a></li>
								@endif
								@if ($config->instagram)
									<li><a target="_blank" href="{{$config->instagram}}" title="Instagram"><i class="fa fa-instagram"></i></a></li>
								@endif
								@if ($config->linkedin)
									<li><a target="_blank" href="{{$config->linkedin}}" title="linkedin"><i class="fa fa-linkedin"></i></a></li>
								@endif
							</ul>
					</div>
				
				<div class="col-lg-4 col-sm-12 col-xs-12 footer-widget">
					<h3 class="widget-title">Links úteis</h3>
					<ul>
						<li>
							<i class="fa fa-angle-double-right"></i>
							<a href="{{route('web.guiaUbatuba')}}"><span class="catTitle">Guia Comercial Ubatuba</span></a> 
						</li>
						<li>
							<i class="fa fa-angle-double-right"></i>
							<a href="{{route('web.anunciar')}}" target="_blank"><span class="catTitle">Anunciar</span></a> 
						</li>
						<li>
							<i class="fa fa-angle-double-right"></i>
							<a href="{{route('web.blog.artigos')}}"><span class="catTitle">Blog</span></a> 
						</li>
						<li>
							<i class="fa fa-angle-double-right"></i>
							<a href="{{route('web.pesquisa')}}"><span class="catTitle">Pesquisar no site</span></a> 
						</li>
						<li>
							<i class="fa fa-angle-double-right"></i>
							<a href="{{route('web.noticias')}}"><span class="catTitle">Notícias</span></a> 
						</li>
						<li>
							<i class="fa fa-angle-double-right"></i>
							<a href="{{route('web.ondas')}}"><span class="catTitle">Boletim das Ondas</span></a> 
						</li>
						<li>
							<i class="fa fa-angle-double-right"></i>
							<a href="{{route('web.tempo')}}"><span class="catTitle">Previsão do Tempo</span></a> 
						</li>
						<li>
							<i class="fa fa-angle-double-right"></i>
							<a href="{{route('web.blog.categoria', [ 'slug' => 'praias-de-ubatuba' ])}}"><span class="catTitle">Praias de Ubatuba</span></a> 
						</li>
						<li>
							<i class="fa fa-angle-double-right"></i>
							<a href="{{route('web.blog.categoria', [ 'slug' => 'wiki-ubatuba' ])}}"><span class="catTitle">Wiki Ubatuba</span></a> 
						</li>
						<li>
							<i class="fa fa-angle-double-right"></i>
							<a href="{{route('web.politica')}}"><span class="catTitle">Política de Privacidade</span></a> 
						</li>
					</ul>
				</div>
				
				<div class="col-lg-4 col-sm-12 col-xs-12 footer-widget">
					<h3 class="widget-title">Instagram Posts</h3>
					            
				</div>
							
				</div>
			</div>
			</div>    
		</footer>
		<!-- Footer End -->
		
		<div class="copyright">
			<div class="container">
				<div class="row">
					<div class="col-sm-12 col-md-12 text-center">
						<div class="utf_copyright_info"> 
							<span>© {{$config->init_date}} Copyright {{$config->app_name}}.Todos os direitos reservados.</span> 
						</div>
					</div>        
					<div class="col-sm-12 col-md-12 text-center">
						<div class="utf_copyright_info"> 
							<p class="font-accent">
								<span class="small text-silver-dark">Feito com <i style="color:red;" class="fa fa-heart"></i> por <a style="color:#fff;" target="_blank" href="{{config('app.desenvolvedor_url')}}">{{config('app.desenvolvedor')}}</a></span>
							</p>
						</div>
					</div>        
				</div>      
				<div id="back-to-top" class="back-to-top">
					<button class="btn btn-primary" title="Back to Top"> <i class="fa fa-angle-up"></i> </button>
				</div>
			</div>
		</div>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

	<script type="text/javascript" src="{{url(asset('frontend/assets/js/jquery.min.js'))}}"></script>
	<script type="text/javascript" src="{{url(asset('frontend/assets/js/popper.min.js'))}}"></script>
	<script type="text/javascript" src="{{url(asset('frontend/assets/js/bootstrap.min.js'))}}"></script>
	<script type="text/javascript" src="{{url(asset('frontend/assets/js/owl.carousel.min.js'))}}"></script>	
	<script type="text/javascript" src="{{url(asset('frontend/assets/js/jquery.colorbox.js'))}}"></script>	
	<script type="text/javascript" src="{{url(asset('frontend/assets/js/smoothscroll.js'))}}"></script>
	<script type="text/javascript" src="{{url(asset('frontend/assets/js/custom_script.js'))}}"></script>

	@hasSection('js')
        @yield('js')
    @endif

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