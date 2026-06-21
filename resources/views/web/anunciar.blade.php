<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#ec0000">
	<meta name="msvalidate.01" content="AB238289F13C246C5E386B6770D9F10E" />

    <meta name="copyright" content="{{ $config->init_date }} - {{ $config->app_name }}">
    <meta name="language" content="pt-br" />
    <meta name="author" content="{{ env('DESENVOLVEDOR') }}"/>
    <meta name="designer" content="Renato Montanari">
    <meta name="publisher" content="Renato Montanari">
    <meta name="url" content="{{ $config->domain }}" />
    <meta name="keywords" content="{{ $config->metatags }}">
    <meta name="distribution" content="web">
    <meta name="rating" content="general">
    <meta name="date" content="{{ \Carbon\Carbon::now()->format('M Y') }}">

    {!! $head ?? '' !!}

	<!-- STYLE  -->
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/style.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/responsive.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/owl.theme.default.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('frontend/assets/css/renato.css') }}">

	{{-- Font Awesome 6 via CDN (o font-awesome.min.css local antigo era v4, removido) --}}
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:300,400,500,600,700,800&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,500,600,700,800&display=swap" rel="stylesheet">

	<!-- Favicon and touch icons  -->
	<link href="{{ $config->getfaveicon() }}" rel="apple-touch-icon-precomposed" sizes="144x144">
	<link href="{{ $config->getfaveicon() }}" rel="apple-touch-icon-precomposed" sizes="114x114">
	<link href="{{ $config->getfaveicon() }}" rel="apple-touch-icon-precomposed" sizes="72x72">
	<link href="{{ $config->getfaveicon() }}" rel="apple-touch-icon-precomposed">
	<link href="{{ $config->getfaveicon() }}" rel="shortcut icon">

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

    <style>
        p {
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

		<div class="mx-auto max-w-6xl space-y-10 px-4 py-10">

			<!-- LOGO -->
			<div class="flex justify-center">
				<img src="{{ $config->getlogo() }}"
					alt="{{ $config->app_name }}"
					class="max-h-20 object-contain">
			</div>

			<!-- TÍTULO -->
			<div class="space-y-2 text-center">
				<h1 class="text-3xl font-bold text-gray-800">
					Anuncie no {{ $config->app_name }}
				</h1>
				<p class="text-gray-500">
					Alcance milhares de pessoas todos os dias
				</p>
			</div>

			<!-- GRÁFICOS -->
			<div class="grid gap-6 md:grid-cols-2">

				<!-- VISITAS -->
				<div class="flex flex-col rounded-2xl bg-white p-6 shadow" wire:ignore>
					<h2 class="mb-4 text-lg font-semibold text-gray-700">
						Crescimento de Visitas
					</h2>
					<div class="min-h-[300px] flex-1">
						<canvas id="visitasChart"></canvas>
					</div>
				</div>

				<!-- POSTS -->
				<div class="flex flex-col rounded-2xl bg-white p-6 shadow" wire:ignore>
					<h2 class="mb-4 text-lg font-semibold text-gray-700">
						Conteúdo do Portal
					</h2>
					<div class="min-h-[300px] flex-1">
						<canvas id="postsChart"></canvas>
					</div>
				</div>

			</div>

			<!-- DESTAQUE VISITAS -->
			<div class="rounded-2xl border border-blue-100 bg-blue-50 p-6 text-center">
				<p class="text-lg text-gray-600">
					Nos últimos 12 meses foram mais de
				</p>
				<h2 class="my-2 text-3xl font-bold text-blue-600">
					{{ number_format($visitas, 0, '', '.') }}
				</h2>
				<p class="text-gray-600">
					visitas no portal
				</p>
				<p class="mt-2 text-sm text-gray-500">
					Média de {{ number_format($visitas / 365, 0) }} acessos por dia
				</p>
			</div>

			<!-- TEXTO -->
			<div class="grid gap-8 md:grid-cols-2">

				<div class="space-y-3">
					<h2 class="text-xl font-semibold text-gray-800">
						Maior Visibilidade
					</h2>
					<p class="leading-relaxed text-gray-600">
						O Ubatuba Times é o maior portal de notícias de Ubatuba e Litoral Norte de SP.
						Sua marca será vista diariamente por milhares de visitantes,
						aumentando reconhecimento e credibilidade.
					</p>
				</div>

				<div class="space-y-3">
					<h2 class="text-xl font-semibold text-gray-800">
						Redes Sociais
					</h2>
					<p class="leading-relaxed text-gray-600">
						Estamos presentes nas principais redes sociais com audiência crescente.
						Sua marca também pode aparecer nesses canais, ampliando ainda mais o alcance.
					</p>
				</div>

			</div>

			<!-- FORM -->
			<div class="rounded-2xl bg-white p-6 shadow">
				<h2 class="mb-2 text-xl font-semibold text-gray-800">
					Solicite um orçamento
				</h2>
				<p class="mb-4 text-gray-500">
					Prometemos não enviar spam <i class="fa-regular fa-face-smile-wink text-amber-500" aria-hidden="true"></i>
				</p>

				<livewire:web.contact-form />
			</div>

		</div>

		{{-- Copyright --}}
		<div class="bg-slate-950 py-6">
			<div class="mx-auto max-w-7xl px-4">
				<div class="flex flex-col items-center gap-2 text-center">
					<span class="text-sm text-slate-400">
						© {{ $config->init_date }} Copyright {{ $config->app_name }}. Todos os direitos reservados.
					</span>
					<p class="text-sm text-slate-400">
						Feito com <i class="fa-solid fa-heart text-red-500" aria-hidden="true"></i> por
						<a target="_blank" rel="noopener" href="{{ config('app.desenvolvedor_url') }}" class="text-white transition hover:text-slate-200">
							{{ config('app.desenvolvedor') }}
						</a>
					</p>
				</div>

				<button id="back-to-top"
						type="button"
						title="Voltar ao topo"
						aria-label="Voltar ao topo"
						class="fixed bottom-6 right-6 z-50 hidden h-11 w-11 items-center justify-center rounded-full bg-red-600 text-white shadow-lg transition hover:bg-red-700">
					<i class="fa-solid fa-angle-up" aria-hidden="true"></i>
				</button>
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
						legend: { display: true }
					},
					scales: {
						y: { beginAtZero: true }
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
						data: [dataPosts.artigos, dataPosts.noticias],
						borderWidth: 1
					}]
				},
				options: {
					responsive: true,
					plugins: {
						legend: { position: 'bottom' }
					}
				}
			});
		});

		// Back to top
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

	@livewireScripts
</body>
</html>