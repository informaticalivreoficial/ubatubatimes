@extends('web.master.master')

@section('content')
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li>Previsão do tempo para Ubatuba</li>
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
                                <h3>Atualização: <span>{{ Carbon\Carbon::now()->format('d/m/Y') }}</span></h3>    
                            </div>   
                            @foreach ($boletim as $item)
                            
                                <div class="col-sm-12 col-md-3">                       
                                    <p style="text-align: center;padding-bottom:10px;margin-bottom: 10px;border-bottom: 3px solid #e9eaea;">
                                        <img src="{{url(asset('frontend/assets/images/'.$item['img']))}}" alt="" title=""/><br>
                                        <b>{{$item['data']}}</b><br>
                                        <b>{{$item['previsao']}}</b><br>                                           
                                        <b>Mínima:</b> {{$item['minima']}}&deg;<br>   
                                        <b>Mínima:</b> {{$item['maxima']}}&deg;<br> 
                                        <b>Índice UV:</b> <span style="padding:5px;{{$item['iuvcolor']}}">{{$item['iuv']}}</span><br>  
                                    </p>                                   
                                </div>
                            @endforeach 
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
  </section>
@endsection