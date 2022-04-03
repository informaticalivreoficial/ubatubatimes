<!DOCTYPE html>
<!--[if IE 8 ]><html class="ie" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="en-US"> <![endif]-->
<!--[if (gte IE 9)|!(IE)]><!--><html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en-US" lang="pt-br"><!--<![endif]-->
<head>
	<!-- Basic Page Needs -->
	<meta charset="utf-8">
	<!--[if IE]><meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->	
    <!-- Mobile Specific Metas -->
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

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

	<!-- Bootstrap  -->
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/bootstrap.css'))}}" >

	<!-- Theme Style -->
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/style.css'))}}">

	<!-- Colors -->
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/colors/color1.css'))}}">
   
	<!-- Animation Style -->
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/animate.css'))}}">

	<!-- Google Fonts 
	<link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>-->

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
   	<!-- Header -->
   	<header id="header" class="header">
	   	<div class="top-wrap">
			<div class="container">
				<div class="row">
					<div class="col-md-6">
		              	<div id="logo" class="logo">
							<a href="{{route('web.home')}}" rel="home" title="{{$configuracoes->nomedosite}}">
								<img src="{{$configuracoes->getLogomarca()}}" alt="{{$configuracoes->nomedosite}}" />
							</a>
		            	</div>		            	
		            </div><!-- /.col-md-6 -->
		            <div class="col-md-6">
		            	<div class="btn-menu"></div><!-- //mobile menu button -->
		            	<div class="member-area">
		            		<span class="login-popup"><a href="#login-modal">Login</a></span>
		            		<span class="signup-popup"><a href="#signup-modal">Become a member</a></span>
		            	</div>
		            </div><!-- /.col-md-6 -->
	            </div><!-- /.row -->
	         </div><!-- /.container -->
	   	</div><!-- /.top-wrap -->
		<div class="header-wrap">
		 <div class="container">
		    <div class="row">
				<div class="col-md-9">
					<nav id="mainnav" class="mainnav">
						<ul class="menu">
							<li><a class="active" href="{{route('web.home')}}">Guia</a></li>
							<li class="has-children"><a href="">Colunas</a>
								<ul class="sub-menu">
									<li><a href="index-banner.html">Home with Banner</a></li>
									<li><a href="index-custom.html">Home Customize</a></li>									
								</ul>
							</li>
							<li><a class="active" href="{{route('web.home')}}">Praias de Ubatuba</a></li>
							<li class="has-children"><a href="">Região</a>
								<ul class="sub-menu">
									<li><a href="index-banner.html">Home with Banner</a></li>
									<li><a href="index-custom.html">Home Customize</a></li>									
								</ul>
							</li>												
							
							<li><a href="ui-elements.html">Wiki Ubatuba</a></li>
						</ul><!-- /.menu -->
					</nav><!-- /nav -->
				</div><!-- /.col-md-9 -->
				<div class="col-md-3">
					<div class="search-wrap">
						<div class="search-icon"></div><!-- //mobile search button -->
						<form action="#" id="searchform" class="search-form" method="get" role="search">
							<input type="text" id="s" placeholder="Search" class="search-field">
							<input type="submit" value="&#xf002;" id="searchsubmit" class="search-submit">
							<a class="search-close" href="#"><i class="fa fa-times-circle"></i></a>
						</form>
					</div><!-- /.search-wrap -->
				</div><!-- /.col-md-3 -->
		    </div><!-- /.row -->
		 </div><!-- /.container -->
		</div><!-- /.header-wrap -->
	</header>

	<section id="main">
		<div class="container">
			@yield('content')
		</div>
	</div>

	<!-- Footer -->
	<footer id="footer">
		<div class="footer-widgets">
			<div class="container">
				<div class="row">
					<div class="col-md-4 gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
						<div class="widget widget-brand">
							<div class="logo logo-footer">
								<a href="#"><img src="images/logo-footer.svg" alt="Good News"></a>
							</div>
							<p>This pays especially well in technology, where you earn a premium for working fast.</p>
						</div><!-- /.widget-brand -->
						<div class="widget widget-social">
							<h5 class="widget-title">Follow Us</h5>
							<div class="social-list">
								<a href="#"><img src="images/facebook.svg" alt="image"></a>
								<a href="#"><img src="images/twitter.svg" alt="image"></a>
								<a href="#"><img src="images/youtube.svg" alt="image"></a>
								<a href="#"><img src="images/dribbble.svg" alt="image"></a>
							</div>
							<a class="email" href="#">hello@youraddress.com</a>
						</div><!-- /.widget-social -->
					</div><!-- /.col-md-4 -->
					<div class="col-md-4 gn-animation" data-animation="fadeInUp" data-animation-delay="0.2s" data-animation-offset="75%">
						<div class="widget widget-twitter">
							<h5 class="widget-title">Twitter</h5>
							<div class="latest-tweets" data-number="3" data-username="envato" data-modpath="./twitter/index.php"></div>
						</div><!-- /.widget-twitter -->
					</div><!-- /.col-md-4 -->
					<div class="col-md-2 gn-animation" data-animation="fadeInUp" data-animation-delay="0.4s" data-animation-offset="75%">
						<div class="widget widget-list">
							<h5 class="widget-title">Main</h5>
							<ul class="links-list">
								<li><a href="#">Mustreads</a></li>
								<li><a href="#">Tech</a></li>
								<li><a href="#">Business</a></li>
								<li><a href="#">Entertainment</a></li>
								<li><a href="#">Social Media</a></li>
							</ul>
						</div><!-- /.widget-list -->
					</div><!-- /.col-md-2 -->
					<div class="col-md-2 gn-animation" data-animation="fadeInUp" data-animation-delay="0.6s" data-animation-offset="75%">
						<div class="widget widget-list">
							<h5 class="widget-title">About Us</h5>
							<ul class="links-list">
								<li><a href="#">About Us</a></li>
								<li><a href="#">Our Team</a></li>
								<li><a href="#">Careers </a></li>
								<li><a href="#">Advertise</a></li>
								<li><a href="#">Copyright</a></li>
							</ul>
						</div><!-- /.widget-list -->
					</div><!-- /.col-md-2 -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div><!-- /.footer-widgets -->
		<div class="footer-copyright">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						&copy; 2014 Good News, Inc.
					</div><!-- /.col-md-12 -->
				</div><!-- /.row -->
			</div><!-- /.container -->
		</div>
	</footer>

	<!-- Login and Signup Form -->
    <div id="login-modal" class="login popup" style="display: none;">
        <a class="close-modal" href="#"></a>
        <div class="form-title">
            <h4>Login</h4>
            <div class="signup">
                No account yet? <a href="#">Sign Up</a>
            </div>
        </div>
        <div class="login-by">
            <div class="log-face-w">
                <a class="log-facebook" href="#">Login with Facebook</a>
            </div>
            <div class="log-twit-w">
                <a class="log-twitter" href="#">Login with Twitter</a>
            </div>
        </div>
        <form id="loginform" name="loginform" method="post">
            <div class="email-wrap">
                <input type="text" size="30" value="" class="input" id="user-email" name="log" placeholder="Email">
            </div>     
            <div class="pass-wrap">
                <input type="password" size="30" value="" class="input" id="user-pass" name="password" placeholder="Password">
            </div>
            <div class="option-login">
                <div class="remember">
                    <input type="checkbox" name="check3" id="check3" class="css-checkbox" checked="checked"/><label for="check3" class="css-label">Remember me</label>
                </div>
                <div class="forgot">
                    <a href="#">I forgot my password</a>
                </div>
            </div>
            <div class="submit-login">
                <input type="submit" value="Log In" class="submit" id="submit" name="submit">
            </div>
        </form>
    </div>
    <div id="signup-modal" class="popup" style="display: none;">
        <a class="close-modal" href="#"></a>
        <div class="form-title">
            <h4>Sign Up</h4>
            <div class="signup">
                Already a member? <a href="#">Login</a>
            </div>
        </div>
        <div class="login-by">
            <div class="log-face-w">
                <a class="log-facebook" href="#">Login with Facebook</a>
            </div>
            <div class="log-twit-w">
                <a class="log-twitter" href="#">Login with Twitter</a>
            </div>
        </div>
        <form id="signupform" name="signupform" method="post">
            <div class="name-wrap">
                <input type="text" size="30" value="" class="input" id="user-name" name="name" placeholder="Name">
            </div> 
            <div class="email-wrap">
                <input type="text" size="30" value="" class="input" id="user-email2" name="log" placeholder="Email">
            </div>     
            <div class="pass-wrap">
                <input type="password" size="30" value="" class="input" id="user-pass2" name="password" placeholder="Password">
            </div>

            <div class="option-login">
                <div class="remember">
                    <input type="checkbox" name="check4" id="check4" class="css-checkbox" checked="checked"/><label for="check4" class="css-label">Remember me</label>
                </div>
                <div class="forgot">
                    <a href="#">I forgot my password</a>
                </div>
            </div>

            <div class="submit-login">
                <input type="submit" value="Sign Up" class="submit" id="submit2" name="submit">
            </div>
        </form>
    </div>

	<!-- Go Top -->
	<a class="go-top">
		<i class="fa fa-chevron-up"></i>
	</a>

	<script type="text/javascript" src="{{url(mix('frontend/assets/js/jquery.min.js'))}}"></script>
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/jquery.easing.js'))}}"></script>
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/matchMedia.js'))}}"></script>
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/bootstrap.min.js'))}}"></script>	
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/libs.js'))}}"></script>	
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/main.js'))}}"></script>

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