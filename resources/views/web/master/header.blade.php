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
                @if($cotacao)
                    <div class="numbers">
                        <span class="value bra">{{ $cotacao['name'] }} R$ {{ $cotacao['ask'] }}</span>
                        <span class="data {{ $cotacao['cor'] }}">{{ $cotacao['sinal'] }} {{ $cotacao['pct'] }}%</span>
                    </div>
                @endif
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