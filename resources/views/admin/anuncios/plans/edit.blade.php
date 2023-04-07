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
        <h1>Editar Plano</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('plans')}}">Planos</a></li>
            <li class="breadcrumb-item active">Editar Plano</li>
        </ol>
    </div>
</div>
@stop

@section('content')
<!-- Main content -->
<section class="content text-muted">
    <div class="container-fluid">
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
        <div class="row">
            <div class="col-12">
                <div class="card card-teal card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-conteudo" role="tab" aria-controls="custom-tabs-conteudo" aria-selected="true">Conteúdo</a>
                            </li>                           
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <form action="{{ route('plans.update', ['id' => $plan->id]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')  
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-conteudo" role="tabpanel" aria-labelledby="custom-tabs-conteudo-tab">
                                <div class="row mb-2">
                                    <div class="col-12"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Tipo de pagamento</b></label>
                                            <div class="form-check">
                                                <input id="tipounico" class="form-check-input" type="radio" value="1" name="tipo_pagamento" {{(old('tipo_pagamento') == '1' ? 'checked' : ( $plan->tipo_pagamento == '1' ? 'checked' : ''))}}>
                                                <label for="tipounico" class="form-check-label mr-5">Único</label>
                                                <input id="tiporecorrente" class="form-check-input" type="radio" value="0" name="tipo_pagamento" {{(old('tipo_pagamento') == '0' ? 'checked' : ( $plan->tipo_pagamento == '0' ? 'checked' : '') )}}>
                                                <label for="tiporecorrente" class="form-check-label">Recorrente</label>
                                            </div>
                                        </div>
                                    </div>                        
                                </div> 
                                <div class="row mb-2">
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-2">
                                        <label class="labelforms text-muted"><b>Valor</b></label>
                                        <input type="text" class="form-control mask-money v" name="valor" value="{{ old('valor') ?? $plan->valor }}">
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-2">
                                        <label class="labelforms text-muted"><b>Mensal</b></label>
                                        <input type="text" class="form-control mask-money m" name="valor_mensal" value="{{ old('valor_mensal') ?? $plan->valor_mensal }}">
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-2">
                                        <label class="labelforms text-muted"><b>Trimestral</b></label>
                                        <input type="text" class="form-control mask-money t" name="valor_trimestral" value="{{ old('valor_trimestral') ?? $plan->valor_trimestral }}">
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-2">
                                        <label class="labelforms text-muted"><b>Semestral</b></label>
                                        <input type="text" class="form-control mask-money s" name="valor_semestral" value="{{ old('valor_semestral') ?? $plan->valor_semestral }}">
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-2">
                                        <label class="labelforms text-muted"><b>Anual</b></label>
                                        <input type="text" class="form-control mask-money a" name="valor_anual" value="{{ old('valor_anual') ?? $plan->valor_anual }}">
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 col-lg-2">
                                        <label class="labelforms text-muted"><b>Bi-anual</b></label>
                                        <input type="text" class="form-control mask-money b" name="valor_bianual" value="{{ old('valor_bianual') ?? $plan->valor_bianual }}">
                                    </div>
                                </div>                      
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="labelforms"><b>*Título:</b></label>
                                            <input class="form-control" name="name" placeholder="Título" value="{{old('name') ?? $plan->name}}">
                                        </div>
                                    </div>                                    
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="labelforms"><b>30 dias de Avaliação?</b></label>
                                            <select name="avaliacao" class="form-control">
                                                <option value="1" {{ (old('avaliacao') == '1' ? 'selected' : ($plan->avaliacao == '1' ? 'selected' : '')) }}>Sim</option>
                                                <option value="0" {{ (old('avaliacao') == '0' ? 'selected' : ($plan->avaliacao == '0' ? 'selected' : '')) }}>Não</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Status:</b></label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ (old('status') == '1' ? 'selected' : ($plan->status == '1' ? 'selected' : '')) }}>Publicado</option>
                                                <option value="0" {{ (old('status') == '0' ? 'selected' : ($plan->status == '0' ? 'selected' : '')) }}>Rascunho</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">                                    
                                    <div class="col-12">   
                                        <label class="labelforms"><b>Conteúdo:</b></label>
                                        <x-adminlte-text-editor name="content" v placeholder="Conteúdo do post..." :config="$config">{{ old('content') ?? $plan->content }}</x-adminlte-text-editor>                                                      
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                        <div class="row text-right">
                            <div class="col-12 mb-4">
                                <button type="submit" class="btn btn-success btn-lg"><i class="nav-icon fas fa-check mr-2"></i> Atualizar Agora</button>
                            </div>
                        </div>
                        </form>
                    </div>                    
                </div>                
                
            </div>
        </div>
    </div>
</section>
@stop

@section('css')
    
@stop

@section('js')
    <script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
    <script>
        $(document).ready(function () { 
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
            
            function tipoPagamento() {
                if ($('#tipounico').prop('checked')) {
                    $('.m, .t, .s, .a, .b').prop('disabled', true);
                    $('.v').prop('disabled', false);
                }else if($('#tiporecorrente').prop('checked')){
                    $('.m, .t, .s, .a, .b').prop('disabled', false);
                    $('.v').prop('disabled', true);
                }else{
                    $('.v, .m, .t, .s, .a, .b').prop('disabled', true);
                }
            } 

            tipoPagamento();

            $('#tipounico').change( function(){
                if(this.checked){
                    $('.m, .t, .s, .a, .b').prop('disabled', true);
                    $('.v').prop('disabled', false);
                }
            });
            $('#tiporecorrente').change( function(){
                if(this.checked){
                    $('.v').prop('disabled', true);
                    $('.m, .t, .s, .a, .b').prop('disabled', false);
                }
            });
        });
    </script>
@stop