@extends('web.master.master')

@section('content')
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li>Boletim das Ondas para Ubatuba</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="utf_block_wrapper">
    <div class="container">
        <div class="col-12">            
            <div class="row justify-content-md-center">
                <div class="col-md-12">
                    @if(!empty($boletim))
                        <div class="row">
                            <div class="col-12">
                                <h3>Atualização: <span>{{ Carbon\Carbon::parse($boletim->getContent()->atualizacao)->format('d/m/Y') }}</span></h3>    
                            </div>                      
                            <div class="col-sm-12 col-md-6">                       
                                <h4 style="float: left" class="mr-2">Manhã:</h4>
                                  <img  width="55" src="{{$boletim->ondasAlturaManha()['img']}}" alt="{{$boletim->ondasAlturaManha()['img']}}">    
                                <ul class="list-round mr_bottom-20">
                                    <li>Situação do mar: {{$boletim->getContent()->manha->agitacao}}</li>
                                    <li>Altura das ondas: {{$boletim->ondasAlturaManha()['altura']}}</li>
                                    <li>Direção do mar: {{$boletim->getContent()->manha->direcao}}</li>
                                    <li>Vento: {{$boletim->getContent()->manha->vento}}</li>
                                    <li>Vento direção: {{$boletim->getContent()->manha->vento_dir}}</li>
                                </ul>                                      
                            </div>
                            <div class="col-sm-12 col-md-6">                       
                                <h4 style="float: left" class="mr-2">Tarde:</h4>
                                  <img  width="55" src="{{$boletim->ondasAlturaTarde()['img']}}" alt="{{$boletim->ondasAlturaTarde()['img']}}">    
                                <ul class="list-round mr_bottom-20">
                                    <li>Situação do mar: {{$boletim->getContent()->tarde->agitacao}}</li>
                                    <li>Altura das ondas: {{$boletim->ondasAlturaTarde()['altura']}}</li>
                                    <li>Direção do mar: {{$boletim->getContent()->tarde->direcao}}</li>
                                    <li>Vento: {{$boletim->getContent()->tarde->vento}}</li>
                                    <li>Vento direção: {{$boletim->getContent()->tarde->vento_dir}}</li>
                                </ul>                                       
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
  </section>
@endsection