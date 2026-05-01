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
    <meta name="author" content="{{env('DESENVOLVEDOR')}}"/>
    <meta name="designer" content="Renato Montanari">
    <meta name="publisher" content="Renato Montanari">
    <meta name="url" content="{{$config->domain}}" />
    <meta name="keywords" content="{{$config->metatags}}">
    <meta name="distribution" content="web">
    <meta name="rating" content="general">
    <meta name="date" content="Dec 26">

    {!! $head ?? '' !!}

	<!-- STYLE  -->
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/bootstrap.min.css')}}" >
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/style.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/responsive.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/font-awesome.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/owl.theme.default.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('frontend/assets/css/renato.css')}}">

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

    <style>
        p{
            font-family: "Nunito", "HelveticaNeue", "Helvetica Neue", Helvetica, Arial, sans-serif;            
            text-rendering: optimizeLegibility;
            font-size: 15px;
            line-height: 26px;
            font-weight: 500;
            color: #6c6c6c;
        }
    </style>

	@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
	<div class="body-inner">	
		
		<div class="max-w-6xl mx-auto px-4 py-10 space-y-10">

			<!-- LOGO -->
			<div class="flex justify-center">
				<img src="{{$config->getlogo()}}"
					alt="{{$config->app_name}}"
					class="max-h-20 object-contain">
			</div>

			<!-- TÍTULO -->
			<div class="text-center space-y-2">
				<h1 class="text-3xl font-bold text-gray-800">
					Anuncie no {{$config->app_name}}
				</h1>
				<p class="text-gray-500">
					Alcance milhares de pessoas todos os dias
				</p>
			</div>

			<!-- GRÁFICOS -->
			<div class="grid md:grid-cols-2 gap-6">

				<!-- VISITAS -->
				<div class="bg-white rounded-2xl shadow p-6 flex flex-col" wire:ignore>
					<h2 class="text-lg font-semibold mb-4 text-gray-700">
						Crescimento de Visitas
					</h2>

					<div class="flex-1 min-h-[300px]">
						<canvas id="visitasChart"></canvas>
					</div>
				</div>

				<!-- POSTS -->
				<div class="bg-white rounded-2xl shadow p-6 flex flex-col" wire:ignore>
					<h2 class="text-lg font-semibold mb-4 text-gray-700">
						Conteúdo do Portal
					</h2>

					<div class="flex-1 min-h-[300px]">
						<canvas id="postsChart"></canvas>
					</div>
				</div>

			</div>

			<!-- DESTAQUE VISITAS -->
			<div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 text-center">
				<p class="text-gray-600 text-lg">
					Nos últimos 12 meses foram mais de
				</p>

				<h2 class="text-3xl font-bold text-blue-600 my-2">
					{{number_format($visitas,0,'','.')}}
				</h2>

				<p class="text-gray-600">
					visitas no portal
				</p>

				<p class="text-sm text-gray-500 mt-2">
					Média de {{number_format(($visitas / 365),0)}} acessos por dia
				</p>
			</div>

			<!-- TEXTO -->
			<div class="grid md:grid-cols-2 gap-8">

				<div class="space-y-3">
					<h2 class="text-xl font-semibold text-gray-800">
						Maior Visibilidade
					</h2>

					<p class="text-gray-600 leading-relaxed">
						O Ubatuba Times é o maior portal de notícias de Ubatuba e Litoral Norte de SP.
						Sua marca será vista diariamente por milhares de visitantes,
						aumentando reconhecimento e credibilidade.
					</p>
				</div>

				<div class="space-y-3">
					<h2 class="text-xl font-semibold text-gray-800">
						Redes Sociais
					</h2>

					<p class="text-gray-600 leading-relaxed">
						Estamos presentes nas principais redes sociais com audiência crescente.
						Sua marca também pode aparecer nesses canais, ampliando ainda mais o alcance.
					</p>
				</div>

			</div>

			<!-- FORM -->
			<div class="bg-white rounded-2xl shadow p-6">
				<h2 class="text-xl font-semibold mb-2 text-gray-800">
					Solicite um orçamento
				</h2>

				<p class="text-gray-500 mb-4">
					Prometemos não enviar spam 😉
				</p>

				<livewire:web.contact-form />
			</div>

		</div>		
		
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


	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>	

	<script>
		document.addEventListener('DOMContentLoaded', function () {

			const labels = @json($labels);
			const data = @json($visitasMensais);

			if (!labels.length || !data.length) {
				console.warn('Sem dados para gráfico');
				return;
			}

			const ctx = document.getElementById('visitasChart');

			new Chart(ctx, {
				type: 'line',
				data: {
					labels: labels,
					datasets: [{
						label: 'Visitas mensais',
						data: data,
						tension: 0.3,
						fill: true,
						borderWidth: 2,
					}]
				},
				options: {
					responsive: true,
					plugins: {
						legend: {
							display: true
						}
					},
					scales: {
						y: {
							beginAtZero: true
						}
					}
				}
			});

		});

		document.addEventListener('DOMContentLoaded', function () {

			const dataPosts = @json($postsStats);

			const ctxPosts = document.getElementById('postsChart');

			if (!ctxPosts) return;

			new Chart(ctxPosts, {
				type: 'doughnut',
				data: {
					labels: ['Artigos', 'Notícias'],
					datasets: [{
						data: [
							dataPosts.artigos,
							dataPosts.noticias
						],
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					plugins: {
						legend: {
							position: 'bottom'
						}
					}
				}
			});

		});
	</script>

	@livewireScripts
</body>
</html>