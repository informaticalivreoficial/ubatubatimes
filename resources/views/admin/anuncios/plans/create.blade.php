@extends('adminlte::page')

@section('title', 'Cadastrar Plano')

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
        <h1>Cadastrar Plano</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('plans.index')}}">Planos</a></li>
            <li class="breadcrumb-item active">Cadastrar Plano</li>
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
                        <form action="{{ route('plans.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf   
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-conteudo" role="tabpanel" aria-labelledby="custom-tabs-conteudo-tab">
                                                       
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="labelforms"><b>*Título:</b></label>
                                            <input class="form-control" name="name" placeholder="Título" value="{{old('name')}}">
                                        </div>
                                    </div> 
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="labelforms"><b>30 dias de Avaliação?</b></label>
                                            <select name="avaliacao" class="form-control">
                                                <option value="1" {{ (old('avaliacao') == '1' ? 'selected' : '') }}>Sim</option>
                                                <option value="0" {{ (old('avaliacao') == '0' ? 'selected' : '') }}>Não</option>
                                            </select>
                                        </div>
                                    </div>                                   
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Status:</b></label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ (old('status') == '1' ? 'selected' : '') }}>Publicado</option>
                                                <option value="0" {{ (old('status') == '0' ? 'selected' : '') }}>Rascunho</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>                                
                                <div class="row">                                    
                                    <div class="col-12">   
                                        <label class="labelforms"><b>Conteúdo:</b></label>
                                        <x-adminlte-text-editor name="content" v placeholder="Conteúdo do post..." :config="$config">{{ old('content') }}</x-adminlte-text-editor>                                                      
                                    </div>
                                </div> 
                            </div> 
                        </div> 
                        <div class="row text-right">
                            <div class="col-12 mb-4">
                                <button type="submit" class="btn btn-success btn-lg"><i class="nav-icon fas fa-check mr-2"></i> Cadastrar Agora</button>
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