<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Bootstrap  -->
        <link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/bootstrap.min.css'))}}" >

        <!-- Theme Style -->
        <link rel="stylesheet" type="text/css" href="{{url(mix('frontend/assets/css/style.css'))}}">

        
        
        <!-- Google Fonts -->
        <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500,700' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700' rel='stylesheet' type='text/css'>

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
        
    </head>
    <body>
        <header id="header" class="header">
            <div class="top-wrap">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="logo" class="logo">
                                <a href="{{route('web.home')}}" title="{{$configuracoes->nomedosite}}">
                                    <img src="{{$configuracoes->getLogomarca()}}" alt="{{$configuracoes->nomedosite}}" />
                                </a>
                            </div>
                        </div>
                    </div>
                 </div>
            </div>
        </header>           
        @yield('content-error')        
    </body>
</html>
