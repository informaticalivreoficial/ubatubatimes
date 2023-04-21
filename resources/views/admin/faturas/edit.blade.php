@extends('adminlte::page')

@section('title', 'Editar Fatura')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i>Editar Fatura</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('faturas.index')}}">Faturas</a></li>
            <li class="breadcrumb-item active">Editar Fatura</li>
        </ol>
    </div>
</div> 
@stop

@section('content')
    
<div class="row">
    <div class="col-12">
        @if($errors->all())
             @foreach($errors->all() as $error)
                 @message(['color' => 'danger'])
                 {{ $error }}
                 @endmessage
             @endforeach
         @endif 
         
         @if(session()->exists('message'))
             @message(['color' => session()->get('color')])
             {{ session()->get('message') }}
             @endmessage
         @endif 
    </div>            
</div>
        
<form action="{{route('faturas.update', [ 'id' => $fatura->id ])}}" method="post" enctype="multipart/form-data">
@csrf
<div class="row">            
    <div class="col-12">
        <div class="card card-teal card-outline card-outline-tabs">  
            
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Dados da Fatura</a>
                    </li>             
                </ul>
            </div>
            
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <div class="row mb-2"> 
                            <div class="col-12"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"></label>
                                    <div class="form-check d-inline mx-2">
                                        <input id="pf" class="form-check-input" type="checkbox" name="pfpf" {{(old('pfpf') == 'on' || old('pfpf') == 'true' ? 'checked' : ($fatura->pfpf == true ? 'checked' : ''))}}>
                                        <label for="pf" class="form-check-label mr-5 text-muted">Pessoa Física</label>
                                        <input id="pj" class="form-check-input" type="checkbox" name="pfpj" {{(old('pfpj') == 'on' || old('pfpj') == 'true' ? 'checked' : ($fatura->pfpj == true ? 'checked' : ''))}}>
                                        <label for="pj" class="form-check-label text-muted">Pessoa Jurídica</label>
                                    </div>
                                </div>
                            </div>                                           
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-12 text-muted mb-2">
                                <div class="form-group">
                                    <h5><b>Informações do cliente</b></h5>            
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 pf">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Nome:</b> <small class="text-info">(campo obrigatório)</small></label>
                                    <input class="form-control" name="nome" value="{{old('nome') ?? $fatura->nome}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Email:</b> <small class="text-info">(campo obrigatório)</small></label>
                                    <input class="form-control" name="email" value="{{old('email') ?? $fatura->email }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Telefone:</b> <small class="text-info">(Fixo ou Celular)</small></label>
                                    <input class="form-control celularmask" name="telefone" value="{{old('telefone') ?? $fatura->telefone}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3 pf">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>CPF:</b> <small class="text-info">(campo obrigatório)</small></label>
                                    <input class="form-control cpfmask" name="cpf" value="{{old('cpf') ?? $fatura->cpf}}">
                                </div>
                            </div>                                                                
                        </div>
                        <div class="row mb-2 pj">                            
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Razão social:</b> <small class="text-info">(campo obrigatório)</small></label>
                                    <input class="form-control" name="company" value="{{old('company') ?? $fatura->company}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Nome fantasia:</b></label>
                                    <input class="form-control" name="alias_name" value="{{old('alias_name') ?? $fatura->alias_name}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>CNPJ:</b> <small class="text-info">(campo obrigatório)</small></label>
                                    <input class="form-control cnpjmask" name="cnpj" value="{{old('cnpj') ?? $fatura->cnpj}}">
                                </div>
                            </div>                                                                
                        </div>
                        <div class="row mb-2"> 
                            <div class="col-sm-12 text-muted mb-2">
                                <div class="form-group">
                                    <h5><b>Informações do Boleto</b></h5>            
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-6">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Descrição do produto ou serviço:</b> <small class="text-info">(campo obrigatório, max. 200 caracteres)</small></label>
                                    <input class="form-control" name="titulo" value="{{old('titulo') ?? $fatura->titulo}}">
                                </div>
                            </div>
                            <div class="col-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Tipo de boleto:</b></label>
                                    <select name="tipo_boleto" class="form-control">
                                        <option value="boletoA4" {{ (old('tipo_boleto') == 'boletoA4' ? 'selected' : ($fatura->tipo_boleto == 'boletoA4' ? 'selected' : '')) }}>boletoA4</option>
                                        <option value="boletoCarne" {{ (old('tipo_boleto') == 'boletoCarne' ? 'selected' : ($fatura->tipo_boleto == 'boletoCarne' ? 'selected' : '')) }}>Carnê</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-3 col-md-3 col-lg-3">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Número de parcelas:</b></label>
                                    <select name="numero_parcelas" class="form-control">
                                        @php
                                            for ($x = 1; $x <= 12; $x++) {                                                
                                                echo '<option value='.$x.' '.(old('numero_parcelas') == $x ? 'selected' : ($fatura->numero_parcelas == $x ? 'selected' : '')).'>'.($x == 1 ? 'á vista' : $x.' parcelas').'</option>';
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">                                    
                            <div class="col-3 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Vencimento do boleto:</b> <small class="text-info">(campo obrigatório)</small></label>
                                    <div class="input-group date">
                                        <input type="text" class="form-control datepicker-here" data-language='pt-BR' name="vencimento" value="{{ old('vencimento') ?? \Carbon\Carbon::parse($fatura->vencimento)->format('d/m/Y') }}"/>
                                        <div class="input-group-append">
                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                                                            
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Valor da parcela:</b> <small class="text-info">(valor mínimo por parcela R$ 3,00)</small></label>
                                    <input class="form-control mask-money" name="valor" value="{{old('valor') ?? $fatura->valor}}">
                                </div>
                            </div>                           
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Número do pedido:</b> <small class="text-info">(campo obrigatório)</small></label>
                                    <input class="form-control" name="pedido" value="{{old('pedido') ?? $fatura->pedido}}">
                                </div>
                            </div>                           
                        </div>                   
                    </div> 
                
                    <div class="row text-right">
                        <div class="col-12 mb-4 mt-4">
                            <input type="hidden" name="status" value="pending">
                            <button type="submit" class="btn btn-success"><i class="nav-icon fas fa-check mr-2"></i> Atualizar Fatura</button>
                        </div>
                    </div> 
            </div>        
        </div>
            <!-- /.card -->
        </div>
    </div>
</div>
                        
</form>

@endsection

@section('css')   
<link href="{{url(asset('backend/plugins/airdatepicker/css/datepicker.min.css'))}}" rel="stylesheet" type="text/css">
@stop

@section('js')
<script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
<script src="{{url(asset('backend/plugins/airdatepicker/js/datepicker.min.js'))}}"></script>
<script src="{{url(asset('backend/plugins/airdatepicker/js/i18n/datepicker.pt-BR.js'))}}"></script>
<script>
    $(document).ready(function () { 
        var $Cpf = $(".cpfmask");
        $Cpf.mask('000.000.000-00', {reverse: true});
        var $Cnpj = $(".cnpjmask");
        $Cnpj.mask('00.000.000/0000-00', {reverse: true});               
        var $celularmask = $(".celularmask");
        $celularmask.mask('(99) 99999-9999', {reverse: false});
        var $money = $(".mask-money");
        $money.mask('R$ 000.000.000.000.000,00', {reverse: true, placeholder: "R$ 0,00"});
    });
</script> 
<script>
    $(function () { 

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getPjCheck(){
            if ($('#pj').is(':checked')) {
                $('.pj').attr("style", "display:flex");
                $('.pf').attr("style", "display:none");
            }else{
                $('.pj').attr("style", "display:none");
                $('.pf').attr("style", "display:flex");
            }
        }

        getPjCheck();

        $("#pf").on('change',function() {
            if (this.checked) {
                $('.pj').attr("style", "display:none");
                $("#pj").prop( "checked", false );
                $('.pf').attr("style", "display:flex");
            } else {
                $('.pj').attr("style", "display:flex");
            }
        });    
        
        $("#pj").on('change',function() {
            if (this.checked) {
                $("#pf").prop( "checked", false );
                $('.pf').attr("style", "display:none");
                $('.pj').attr("style", "display:flex");
            } else {
                $('.pf').attr("style", "display:flex");
                $('.pj').attr("style", "display:none");
            }
        });
        

    });
</script>
@endsection