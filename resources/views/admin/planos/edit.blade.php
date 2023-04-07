@extends('adminlte::page')

@section('title', 'Editar Plano')

@php
$config = [
    "height" => "300",
    "fontSizes" => ['8', '9', '10', '11', '12', '14', '18'],
    "lang" => 'pt-BR',
    "toolbar" => [
        // [groupName, [list of button]]
        ['style', ['style']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['style', ['bold', 'italic', 'underline', 'clear']],
        //['font', ['strikethrough', 'superscript', 'subscript']],        
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['table', ['table']],
        ['insert', ['link', 'picture', 'video','hr']],
        ['view', ['fullscreen', 'codeview']],
    ],
]
@endphp

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i>Editar Plano</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('planos.index')}}">Planos</a></li>
            <li class="breadcrumb-item active">Editar Plano</li>
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
                    
            
<form action="{{route('planos.update', $plano->id)}}" method="post">
    @csrf  
    @method('PUT')        
    <div class="row">            
        <div class="col-12">
            <div class="card card-teal card-outline card-outline-tabs">                            
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Informações</a>
                        </li>
                    </ul>
                </div>

                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-four-tabContent">
                        <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        
                            <div class="row mb-2"> 
                                <div class="col-12 col-md-6 col-lg-6"> 
                                    <div class="form-group">
                                        <label class="labelforms text-muted"><b>*Plano</b> </label>
                                        <input type="text" class="form-control" name="name" value="{{ old('name') ?? $plano->name}}">
                                    </div>
                                </div> 
                                <div class="col-12 col-md-6 col-lg-2">   
                                    <div class="form-group">
                                        <label class="labelforms text-muted"><b>Vagas</b></label>
                                        <input type="text" class="form-control" name="vagas" value="{{old('vagas') ?? $plano->vagas}}">
                                    </div>                                                    
                                </div> 
                                <div class="col-12 col-sm-6 col-md-4 col-lg-2"> 
                                    <div class="form-group">
                                        <label class="labelforms text-muted"><b>Horário</b></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control only-time" data-language='pt-BR' name="horario" value="{{ old('horario') ?? $plano->horario }}"/>
                                            <div class="input-group-append">
                                                <div class="input-group-text"><i class="fa fa-clock"></i></div>
                                            </div>
                                        </div>
                                    </div> 
                                </div> 
                                <div class="col-12 col-sm-4 col-md-4 col-lg-2">
                                    <div class="form-group">
                                        <label class="labelforms text-muted"><b>Status:</b></label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ (old('status') == '1' ? 'selected' : ($plano->status == 1 ? 'selected' : '')) }}>Ativo</option>
                                                <option value="0" {{ (old('status') == '0' ? 'selected' : ($plano->status == 0 ? 'selected' : '')) }}>Inativo</option>
                                        </select>
                                    </div>
                                </div>                        
                            </div>
                            
                            <div class="row mb-3">
                                <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                    <label class="labelforms text-muted"><b>Mensal</b></label>
                                    <input type="text" class="form-control mask-money m" name="valor_mensal" value="{{ old('valor_mensal') ?? $plano->valor_mensal }}">
                                </div>
                                <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                    <label class="labelforms text-muted"><b>Trimestral</b></label>
                                    <input type="text" class="form-control mask-money t" name="valor_trimestral" value="{{ old('valor_trimestral') ?? $plano->valor_trimestral }}">
                                </div>
                                <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                    <label class="labelforms text-muted"><b>Semestral</b></label>
                                    <input type="text" class="form-control mask-money s" name="valor_semestral" value="{{ old('valor_semestral') ?? $plano->valor_semestral }}">
                                </div>
                                <div class="col-12 col-sm-6 col-md-3 col-lg-3">
                                    <label class="labelforms text-muted"><b>Anual</b></label>
                                    <input type="text" class="form-control mask-money a" name="valor_anual" value="{{ old('valor_anual') ?? $plano->valor_anual }}">
                                </div>
                            </div>

                            <div class="row mb-2">   
                                <div class="col-12">
                                    <label class="labelforms text-muted"><b>Dias da Semana</b></label>    
                                </div>                                  
                                <div class="col-12 col-sm-6 col-md-4 col-lg-2">                                        
                                    <div class="form-group p-3 mb-1">
                                        <div class="form-check mb-2">
                                            <input id="segunda" class="form-check-input" type="checkbox" name="segunda" {{ (old('segunda') == 'on' || old('segunda') == true ? 'checked' : ($plano->segunda == true ? 'checked' : '')) }}>
                                            <label for="segunda" class="form-check-label text-muted">Segunda</label>
                                        </div>                                            
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-2">                                        
                                    <div class="form-group p-3 mb-1">
                                        <div class="form-check mb-2">
                                            <input id="terca" class="form-check-input" type="checkbox" name="terca" {{ (old('terca') == 'on' || old('terca') == true ? 'checked' : ($plano->terca == true ? 'checked' : '')) }}>
                                            <label for="terca" class="form-check-label text-muted">Terça</label>
                                        </div>                                            
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-2">                                        
                                    <div class="form-group p-3 mb-1">
                                        <div class="form-check mb-2">
                                            <input id="quarta" class="form-check-input" type="checkbox" name="quarta" {{ (old('quarta') == 'on' || old('quarta') == true ? 'checked' : ($plano->quarta == true ? 'checked' : '')) }}>
                                            <label for="quarta" class="form-check-label text-muted">Quarta</label>
                                        </div>                                            
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-2">                                        
                                    <div class="form-group p-3 mb-1">
                                        <div class="form-check mb-2">
                                            <input id="quinta" class="form-check-input" type="checkbox" name="quinta" {{ (old('quinta') == 'on' || old('quinta') == true ? 'checked' : ($plano->quinta == true ? 'checked' : '')) }}>
                                            <label for="quinta" class="form-check-label text-muted">Quinta</label>
                                        </div>                                            
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-2">                                        
                                    <div class="form-group p-3 mb-1">
                                        <div class="form-check mb-2">
                                            <input id="sexta" class="form-check-input" type="checkbox" name="sexta" {{ (old('sexta') == 'on' || old('sexta') == true ? 'checked' : ($plano->sexta == true ? 'checked' : '')) }}>
                                            <label for="sexta" class="form-check-label text-muted">Sexta</label>
                                        </div>                                            
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6 col-md-4 col-lg-2">                                        
                                    <div class="form-group p-3 mb-1">
                                        <div class="form-check mb-2">
                                            <input id="sabado" class="form-check-input" type="checkbox" name="sabado" {{ (old('sabado') == 'on' || old('sabado') == true ? 'checked' : ($plano->sabado == true ? 'checked' : '')) }}>
                                            <label for="sabado" class="form-check-label text-muted">Sábado</label>
                                        </div>                                            
                                    </div>
                                </div>
                                <div class="col-12">   
                                    <label class="labelforms text-muted"><b>Descrição do Plano</b></label>
                                    <x-adminlte-text-editor name="content" v placeholder="Descrição..." :config="$config">{{ old('content') ?? $plano->content }}</x-adminlte-text-editor>                                                                                     
                                </div>
                            </div> 
                        </div>
                    </div>
                    <div class="row text-right">
                        <div class="col-12 my-3">
                            <button type="submit" class="btn btn-lg btn-success"><i class="nav-icon fas fa-check mr-2"></i> Atualizar Agora</button>
                        </div>
                    </div> 
                </div>  
            </div> 
        </div> 
    </div>                    
</form>     
@stop

@section('css')
<link href="{{url(asset('backend/plugins/airdatepicker/css/datepicker.min.css'))}}" rel="stylesheet" type="text/css">
<style>
    .only-timepicker .datepicker--nav,
    .only-timepicker .datepicker--content {
        display: none;
    }
    .only-timepicker .datepicker--time {
        border-top: none;
    }
</style>
@stop


@section('js')
<script src="{{url(asset('backend/plugins/airdatepicker/js/datepicker.min.js'))}}"></script>
<script src="{{url(asset('backend/plugins/airdatepicker/js/i18n/datepicker.pt-BR.js'))}}"></script>
<script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
<script>
    $(document).ready(function () { 
       var $money = $(".mask-money");
        $money.mask('R$ 000.000.000.000.000,00', {reverse: true, placeholder: "R$ 0,00"});
    });
</script>

<script>
    $(function () {         
        $('.only-time').datepicker({
            confirmButton:true,
            clearButton:true,
            autoClose:true,
            // dateFormat: ' ',
            // timeFormat: 'hh:ii',
            // classes: 'only-timepicker'
            dateFormat: ' ',
            timepicker: true,
            classes: 'only-timepicker'
        });
        var okButton = '<span class="datepicker--button" data-action="hide">Ok</span>'; 
        $('.datepicker--button[data-action="clear"]').each(function( index ) { 
            $(okButton).insertBefore($(this)); 
        });
    });
</script>
@stop