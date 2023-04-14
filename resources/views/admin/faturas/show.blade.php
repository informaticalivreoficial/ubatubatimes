@extends('adminlte::page')

@section('title', 'Visualizar Fatura')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
       <h1>Fatura</h1>
    </div>
    <div class="col-sm-6">
       <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('faturas.index')}}">Faturas</a></li>
          <li class="breadcrumb-item active">Fatura</li>
       </ol>
    </div>
 </div>
@stop

@section('content')    
    <section class="content">
       <div class="container-fluid">
          <div class="row">
             <div class="col-12">                
                <div class="invoice p-3 mb-3">
                   <div class="row">
                      <div class="col-12">
                         <h4>
                            <img width="{{env('LOGOMARCA_GERENCIADOR_WIDTH')}}" height="{{env('LOGOMARCA_GERENCIADOR_HEIGHT')}}" src="{{$configuracoes->getlogoadmin()}}" alt="{{$configuracoes->nomedosite}}">
                            <small class="float-right">Data: {{Carbon\Carbon::parse($fatura->created_at)->format('d/m/Y')}}</small>
                         </h4>
                      </div>
                   </div>
                   <div class="row invoice-info">
                      <div class="col-sm-4 invoice-col">
                         De
                         <address>
                           <strong>{{$configuracoes->nomedosite}}</strong><br>
                           @if($configuracoes->rua)	
                              {{$configuracoes->rua}}
                                 @if($configuracoes->num)
                                 , {{$configuracoes->num}}
                                 @endif
                              @if($configuracoes->bairro)
                              <br>{{$configuracoes->bairro}}
                                 @if($configuracoes->cep)
                                 , {{$configuracoes->cep}}
                                 @endif
                              @endif
                              @if($configuracoes->cidade)  
                              <br>{{\App\Helpers\Cidade::getCidadeNome($configuracoes->cidade, 'cidades')}}
                              @endif
                           @endif
                            <br>
                            Fone: {{$configuracoes->whatsapp}}<br>
                            Email: {{$configuracoes->email}}
                         </address>
                      </div>
                      <div class="col-sm-4 invoice-col">
                         Para
                         <address>
                            <strong>{{$fatura->getEmpresa->alias_name}}</strong><br>
                            @if($fatura->getEmpresa->rua)	
                              {{$fatura->getEmpresa->rua}}
                                 @if($fatura->getEmpresa->num)
                                 , {{$fatura->getEmpresa->num}}
                                 @endif
                              @if($fatura->getEmpresa->bairro)
                              <br>{{$fatura->getEmpresa->bairro}}
                                 @if($fatura->getEmpresa->cep)
                                 , {{$fatura->getEmpresa->cep}}
                                 @endif
                              @endif
                              @if($fatura->getEmpresa->cidade)  
                              <br>{{\App\Helpers\Cidade::getCidadeNome($fatura->getEmpresa->cidade, 'cidades')}}
                              @endif
                           @endif
                            <br>
                            Fone: {{$fatura->getEmpresa->celular}}<br>
                            Email: {{$fatura->getEmpresa->email}}
                         </address>
                      </div>
                      <div class="col-sm-4 invoice-col">
                         <b>Pedido #{{$fatura->id}}</b><br>
                         <br>
                         <b>Vencimento:</b> {{Carbon\Carbon::parse($fatura->vencimento)->format('d/m/Y')}}<br>
                      </div>
                   </div>
                   <div class="row">
                      <div class="col-12 table-responsive">
                         <table class="table table-striped">
                            <thead>
                               <tr>
                                  <th>Qtd</th>
                                  <th>Descrição</th>                                  
                                  <th>Subtotal</th>
                               </tr>
                            </thead>
                            <tbody>                                
                                <tr>
                                    <td>1</td>
                                    <td>{{$fatura->getAnuncio->plano->name}}</td> 
                                    @if ($fatura->getAnuncio->periodo == 1)
                                        <td>R$ {{str_replace(',00', '', $fatura->getAnuncio->plano->valor_mensal)}}</td>
                                    @endif  
                                </tr>                                                                                                  
                            </tbody>
                         </table>
                      </div>
                   </div>
                   <div class="row">
                      <div class="col-6">
                         <p class="lead no-print">Forma de Pagamento:</p>
                         @if (!empty($gateways) && $gateways->count() > 0)
                            @foreach ($gateways as $gateway)
                                <label class="gateway no-print" for="{{$gateway->id}}">
                                    <img class="m-2" width="120" src="{{$gateway->logomarca}}" alt="{{$gateway->nome}}">
                                </label>
                                <input class="gateway no-print" type="radio" name="gateway" value="{{$gateway->id}}" id="{{$gateway->id}}" />
                            @endforeach
                         @endif                       
                      </div>
                      <div class="col-6">
                         <p class="lead">Total Hoje {{Carbon\Carbon::parse(now())->format('d/m/Y')}}</p>
                         <div class="table-responsive">
                            <table class="table">
                               <tr>
                                  <th>Total:</th>
                                  <td>R$ {{str_replace(',00', '', $fatura->getAnuncio->plano->valor_mensal)}}</td>
                               </tr>
                            </table>
                         </div>
                      </div>
                   </div>
                   <div class="row no-print">
                      <div class="col-12">
                        <a href="javascript:void(0)" onclick="window.print();"class="btn btn-default">
                           <i class="fas fa-print"></i> Imprimir
                        </a>
                        <a style="margin-right: 5px;" class="btn btn-success float-right" href="{{route('web.pagar',['fatura' => $fatura->id])}}">
                           <i class="far fa-credit-card"></i> Pagar Agora
                        </a>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
    </section>
 </div>
 
@endsection

@section('css')
    <style>
        input[type="radio"] {
                visibility: hidden;
        }
        .selecionada {
            opacity: 0.5;
        }
    </style>
@endsection

@section('js')
    <script>
        $(function () {           
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $(".gateway").each(function(){
                if($(this).find('input[type="radio"]').first().attr("checked")){
                    $(this).addClass('selecionada');
                }else{
                    $(this).removeClass('selecionada');
                }
            });

            $(".gateway").on("click", function(e){
                $(".gateway").removeClass('selecionada');
                $(this).addClass('selecionada');
                var $radio = $(this).find('input[type="radio"]');
                $radio.prop("checked",!$radio.prop("checked"));

                e.preventDefault();
            });           
            
        });
    </script>
@endsection