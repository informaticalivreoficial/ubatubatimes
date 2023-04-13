<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="theme-color" content="#ec0000">
	<meta name="msvalidate.01" content="AB238289F13C246C5E386B6770D9F10E" />

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
	<link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/owl.theme.default.min.css'))}}">
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

</head>

<body>
	<div class="body-inner">
		
		
		<div class="container">
            <div class="row m-2">
                <div class="col-12 mt-3 mb-3 text-center">
                    <img src="{{$configuracoes->getLogomarca()}}" alt="{{$configuracoes->nomedosite}}"> 
                </div>
                <div class="col-12">
                    <h2>Maior Visibilidade</h2>
                    <p>
                        O Ubatuba Times é o Maior Portal de Notícias de Ubatuba e Litoral Norte de SP.
                        O Portal Ubatuba Times registrou a marca de 
                        <b>{{number_format($visitas,0,'','.')}} visitas nos últimos 12 meses</b>. Isso significa que, por dia, o Portal teve uma média de {{number_format(($visitas / 365),0)}} visitas. Quem anuncia a marca no Portal Ubatuba Times é visto e lembrado todos os dias, 24 horas por dia.
                    </p>
                </div>
                <div class="col-12">
                    <h2>Redes Sociais</h2>
                    <p>
                        O Portal Ubatuba Times está presente em várias redes sociais e com um grande número de seguidores que cresce
                        a cada dia, sua marca pode nos acompanhar também nessas redes.Então não perca tempo, por um preço acessível
                        a marca da sua empresa será divulgada em nossos meios de comunicação.                        
                    </p>
                </div>
                <div class="col-12 mb-3">
                    <h2>Preencha o Formulário</h2>
                    <p>Ah, fique tranquilo também odiamos SPAM!!</p>
                    <form action="" method="POST" autocomplete="off" class="j_formsubmit">
                        @csrf
                        <div class="form-group row">
                            <div class="col-lg-12">
                                <div id="js-contact-result"></div>
                                <!-- HONEYPOT -->
                                <input type="hidden" class="noclear" name="bairro" value="" />
                                <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                            </div>                  
                        </div>
                        <div class="form-group row form_hide">
                            <div class="col-lg-4">
                                <label>Nome</label>
                                <input type="text" class="form-control" name="nome">
                            </div>                          
                            <div class="col-lg-4">
                                <label>Email</label>
                                <input type="text" class="form-control" name="email">
                            </div>                          
                            <div class="col-lg-4">
                                <label>WhatsApp</label>
                                <input type="text" class="form-control" name="telefone">
                            </div>                          
                        </div>
                        <div class="form-group row form_hide">
                            <div class="col-lg-12">
                                <label>Nos conte um pouco sobre sua empresa</label>
                                <textarea name="mensagem" rows="10" class="form-control"></textarea>
                            </div>                  
                        </div>                       
                        
                        <button type="submit" id="botao" class="btn btn-primary form_hide">Enviar Agora</button>
                      </form>
                </div>
            </div>
            
        </div>
		
		
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
	<script type="text/javascript" src="{{url(mix('frontend/assets/js/smoothscroll.js'))}}"></script>

	<script>
        $(function () {
    
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
    
            // Seletor, Evento/efeitos, CallBack, Ação
            $('.j_formsubmit').submit(function (){
                var form = $(this);
                var dataString = $(form).serialize();
    
                $.ajax({
                    url: "{{ route('web.sendOrcamento') }}",
                    data: dataString,
                    type: 'GET',
                    dataType: 'JSON',
                    beforeSend: function(){
                        form.find("#botao").attr("disabled", true);
                        form.find('#botao').html("Carregando...");                
                        form.find('.alert').fadeOut(500, function(){
                            $(this).remove();
                        });
                    },
                    success: function(resposta){
                        $('html, body').animate({scrollTop:$('#js-contact-result').offset().top-100}, 'slow');
                        if(resposta.error){
                            form.find('#js-contact-result').html('<div class="alert alert-danger error-msg">'+ resposta.error +'</div>');
                            form.find('.error-msg').fadeIn();                    
                        }else{
                            form.find('#js-contact-result').html('<div class="alert alert-success error-msg">'+ resposta.sucess +'</div>');
                            form.find('.error-msg').fadeIn();                    
                            form.find('input[class!="noclear"]').val('');
                            form.find('textarea[class!="noclear"]').val('');
                            form.find('.form_hide').fadeOut(500);
                        }
                    },
                    complete: function(resposta){
                        form.find("#botao").attr("disabled", false);
                        form.find('#botao').html("Enviar Agora");                                
                    }
                });
    
                return false;
            });
    
        });
    </script>
</body>
</html>