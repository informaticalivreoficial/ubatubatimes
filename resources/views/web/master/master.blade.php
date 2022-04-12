<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#ec0000">

    <meta name="copyright" content="{{$configuracoes->ano_de_inicio}} - {{$configuracoes->nomedosite}}">
    <meta name="language" content="pt-br" /> 
    <meta name="author" content="{{env('DESENVOLVEDOR')}}"/>
    <meta name="designer" content="Renato Montanari">
    <meta name="publisher" content="Renato Montanari">
    <meta name="url" content="{{$configuracoes->dominio}}" />
    <meta name="keywords" content="{{$configuracoes->metatags}}">
    <meta name="distribution" content="web">
    <meta name="rating" content="general">
    <meta name="date" content="Dec 26">

    {!! $head ?? '' !!}

    <meta name="csrf-token" content="{{ csrf_token() }}">

	<!-- STYLE  -->
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/bootstrap.min.css'))}}" >
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/style.css'))}}">
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/responsive.css'))}}">
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/font-awesome.min.css'))}}">
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/owl.carousel.min.css'))}}">
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/owl.theme.default.min.css'))}}">
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/colorbox.css'))}}">
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/renato.css'))}}">

	<!-- Google Fonts --> 
	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,500,600,700,800&display=swap" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700,800&display=swap" rel="stylesheet">

	<!-- Favicon and touch icons  -->
	<link href="{{$configuracoes->getfaveicon()}}" rel="apple-touch-icon-precomposed" sizes="144x144">
	<link href="{{$configuracoes->getfaveicon()}}" rel="apple-touch-icon-precomposed" sizes="114x114">
	<link href="{{$configuracoes->getfaveicon()}}" rel="apple-touch-icon-precomposed" sizes="72x72">
	<link href="{{$configuracoes->getfaveicon()}}" rel="apple-touch-icon-precomposed">
	<link href="{{$configuracoes->getfaveicon()}}" rel="shortcut icon">

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

    @hasSection('css')
        @yield('css')
    @endif
</head>

<body>
	<div class="body-inner">
		
		<div id="top-bar" class="top-bar">
			<div class="container">
				<div class="row">
					<div class="col-md-8">
						<ul class="unstyled top-nav">
							<li><a href="login-signup.html">Login & Signup</a></li>
						</ul>
					</div>
					<div class="col-md-4 top-social text-lg-right text-md-center">
						<ul class="unstyled">
							@if ($configuracoes->facebook)
								<li><a target="_blank" href="{{$configuracoes->facebook}}" title="Facebook"><i class="fa fa-facebook"></i></a></li>
							@endif
							@if ($configuracoes->twitter)
								<li><a target="_blank" href="{{$configuracoes->twitter}}" title="Twitter"><i class="fa fa-twitter"></i></a></li>
							@endif
							@if ($configuracoes->instagram)
								<li><a target="_blank" href="{{$configuracoes->instagram}}" title="Instagram"><i class="fa fa-instagram"></i></a></li>
							@endif
							@if ($configuracoes->linkedin)
								<li><a target="_blank" href="{{$configuracoes->linkedin}}" title="linkedin"><i class="fa fa-linkedin"></i></a></li>
							@endif
						</ul>
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
								<img src="{{$configuracoes->getLogomarca()}}" alt="{{$configuracoes->nomedosite}}"> 
							</a> 
						</div>
					</div>        
					<div class="col-md-9 col-sm-12 header-right">
						<div class="float-right mt-3"> 
							<a href="#">
								<img src="{{url(asset('frontend/assets/images/cavalo.png'))}}" class="img-fluid" alt="">
							</a> 
						</div>
					</div>
				</div>
			</div>
		</header>
		<!-- Header End -->
		
		<!-- Main Nav Start --> 
		<div class="utf_main_nav_area clearfix utf_sticky">
			<div class="container">
			<div class="row">
				<nav class="navbar navbar-expand-lg col">
				<div class="utf_site_nav_inner float-left">
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="true" aria-label="Toggle navigation"> <span class="navbar-toggler-icon"></span> </button>            
					<div id="navbarSupportedContent" class="collapse navbar-collapse navbar-responsive-collapse">
					<ul class="nav navbar-nav">
												               
						<li class="link-colunas"> <a href="category-style2.html"> <b>Guia</b> </a> </li>
						<li> <a href="http://localhost/Ubatuba-Times/public/blog/categoria/praias-de-ubatuba"> <b>Praias de Ubatuba</b> </a> </li>
						<li> <a href=""> <b>Boletim das Ondas</b> </a> </li>

						@if (!empty($catcolunas) && $catcolunas->count() > 0 )
							<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Colunas <i class="fa fa-angle-down"></i></a>
								<ul class="utf_dropdown_menu" role="menu">
									@foreach ($catcolunas as $catc)
										@if ($catc->countposts() >= 1)
											<li> <a href="{{route('web.blog.categoria', [ 'slug' => $catc->slug ])}}"><i class="fa fa-angle-double-right"></i> {{$catc->titulo}}</a></li>
										@endif										
									@endforeach																	
								</ul>
							</li>
						@endif						
						@if (!empty($catnoticias) && $catnoticias->count() > 0 )
							<li class="dropdown"> <a href="#" class="dropdown-toggle" data-toggle="dropdown">Região <i class="fa fa-angle-down"></i></a>
								<ul class="utf_dropdown_menu" role="menu">
									@foreach ($catnoticias as $catn)
										@if ($catn->countposts() >= 1)
											<li> <a href="{{route('web.noticia.categoria', [ 'slug' => $catn->slug ])}}"><i class="fa fa-angle-double-right"></i> {{$catn->titulo}}</a></li>
										@endif										
									@endforeach																	
								</ul>
							</li>
						@endif		
						<li> <a href="http://localhost/Ubatuba-Times/public/blog/categoria/wiki-ubatuba">Wiki Ubatuba</a> </li>				
					</ul>
					</div>            
				</div>
				</nav>        
				<div class="utf_nav_search"> <span id="search"><i class="fa fa-search"></i></span> </div>        
				<div class="utf_search_block" style="display: none;">
				<input type="text" class="form-control" placeholder="Enter your keywords...">
				<span class="utf_search_close">&times;</span> 
				</div>        
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
								<li>{{$configuracoes->descricao}}</li>
								<li><i class="fa fa-home"></i> {{getCidadeNome($configuracoes->cidade, 'cidades')}}</li>
								@if ($configuracoes->telefone1)
									<li><i class="fa fa-phone"></i> <a href="tel:{{$configuracoes->telefone1}}">{{$configuracoes->telefone1}}</a></li>
								@endif
								@if ($configuracoes->telefone2)
									<li><i class="fa fa-phone"></i> <a href="tel:{{$configuracoes->telefone2}}">{{$configuracoes->telefone2}}</a></li>
								@endif
								@if ($configuracoes->telefone3)
									<li><i class="fa fa-phone"></i> <a href="tel:{{$configuracoes->telefone3}}">{{$configuracoes->telefone3}}</a></li>
								@endif								
								@if ($configuracoes->whatsapp)
									<li><i class="fa fa-whatsapp"></i> <a href="{{getNumZap($configuracoes->whatsapp ,$configuracoes->nomedosite)}}">{{$configuracoes->whatsapp}}</a></li>
								@endif								
								@if ($configuracoes->email)
									<li><i class="fa fa-envelope-o"></i> <a href="mailto:{{$configuracoes->email}}">{{$configuracoes->email}}</a></li>
								@endif
								@if ($configuracoes->email1)
									<li><i class="fa fa-envelope-o"></i> <a href="mailto:{{$configuracoes->email1}}">{{$configuracoes->email1}}</a></li>
								@endif											 
							</ul>
							<ul class="unstyled utf_footer_social">
								@if ($configuracoes->facebook)
									<li><a target="_blank" href="{{$configuracoes->facebook}}" title="Facebook"><i class="fa fa-facebook"></i></a></li>
								@endif
								@if ($configuracoes->twitter)
									<li><a target="_blank" href="{{$configuracoes->twitter}}" title="Twitter"><i class="fa fa-twitter"></i></a></li>
								@endif
								@if ($configuracoes->instagram)
									<li><a target="_blank" href="{{$configuracoes->instagram}}" title="Instagram"><i class="fa fa-instagram"></i></a></li>
								@endif
								@if ($configuracoes->linkedin)
									<li><a target="_blank" href="{{$configuracoes->linkedin}}" title="linkedin"><i class="fa fa-linkedin"></i></a></li>
								@endif
							</ul>
					</div>
				
				<div class="col-lg-4 col-sm-12 col-xs-12 footer-widget widget-categories">
					<h3 class="widget-title">Popular Categories</h3>
					<ul>
					<li><i class="fa fa-angle-double-right"></i><a href="#"><span class="catTitle">Make-Up</span><span class="catCounter"> (05)</span></a> </li>
					<li><i class="fa fa-angle-double-right"></i><a href="#"><span class="catTitle">Health</span><span class="catCounter"> (06)</span></a> </li>
					<li><i class="fa fa-angle-double-right"></i><a href="#"><span class="catTitle">Audio</span><span class="catCounter"> (15)</span></a> </li>
					<li><i class="fa fa-angle-double-right"></i><a href="#"><span class="catTitle">Travel</span><span class="catCounter"> (25)</span></a> </li>
					<li><i class="fa fa-angle-double-right"></i><a href="#"><span class="catTitle">Health</span><span class="catCounter"> (05)</span></a> </li>
					<li><i class="fa fa-angle-double-right"></i><a href="#"><span class="catTitle">Gadgets</span><span class="catCounter"> (12)</span></a> </li>
					<li><i class="fa fa-angle-double-right"></i><a href="#"><span class="catTitle">Food</span><span class="catCounter"> (14)</span></a> </li>
					</ul>
				</div>
				
				<div class="col-lg-4 col-sm-12 col-xs-12 footer-widget">
					<h3 class="widget-title">Popular Post</h3>
					<div class="utf_list_post_block">
					<ul class="utf_list_post">
						<li class="clearfix">
						<div class="utf_post_block_style post-float clearfix">
							<div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/health2.jpg" alt="" /> </a> </div>                    
							<div class="utf_post_content">
							<h2 class="utf_post_title title-small"> <a href="#">Santino loganne legan an year old resident...</a> </h2>
							<div class="utf_post_meta"> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
							</div>
						</div>
						</li>
						
						<li class="clearfix">
						<div class="utf_post_block_style post-float clearfix">
							<div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/health3.jpg" alt="" /> </a> </div>                    
							<div class="utf_post_content">
							<h2 class="utf_post_title title-small"> <a href="#">Santino loganne legan an year old resident...</a> </h2>
							<div class="utf_post_meta"> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
							</div>
						</div>
						</li>
						
						<li class="clearfix">
						<div class="utf_post_block_style post-float clearfix">
							<div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/health4.jpg" alt="" /> </a> </div>                    
							<div class="utf_post_content">
							<h2 class="utf_post_title title-small"> <a href="#">Santino loganne legan an year old resident...</a> </h2>
							<div class="utf_post_meta"> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
							</div>
						</div>
						</li>
					</ul>
					</div>            
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
							<span>© {{$configuracoes->ano_de_inicio}} Copyright {{$configuracoes->nomedosite}}.Todos os direitos reservados.</span> 
						</div>
					</div>        
					<div class="col-sm-12 col-md-12 text-center">
						<div class="utf_copyright_info"> 
							<p class="font-accent">
								<span class="small text-silver-dark">Feito com <i style="color:red;" class="fa fa-heart"></i> por <a style="color:#fff;" target="_blank" href="{{env('DESENVOLVEDOR_URL')}}">{{env('DESENVOLVEDOR')}}</a></span>
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

	<script type="text/javascript" src="{{url(mix('frontend/assets/js/jquery.min.js'))}}"></script>
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/popper.min.js'))}}"></script>
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/bootstrap.min.js'))}}"></script>
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/owl.carousel.min.js'))}}"></script>	
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/jquery.colorbox.js'))}}"></script>	
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/smoothscroll.js'))}}"></script>
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/custom_script.js'))}}"></script>

	@hasSection('js')
        @yield('js')
    @endif

    <!-- Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-N886VV2RRF"></script>
    <script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'G-N886VV2RRF');
    </script>
</body>
</html>