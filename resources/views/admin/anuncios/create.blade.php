@extends('adminlte::page')

@section('title', 'Cadastrar Anúncio')

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
        <h1><i class="fas fa-search mr-2"></i>Novo Anúncio</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('anuncios.index')}}">Anúncios</a></li>
            <li class="breadcrumb-item active">Novo Anúncio</li>
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
    </div>            
</div>
        
<form action="{{route('anuncios.store')}}" method="post" enctype="multipart/form-data">
@csrf
<div class="row">            
    <div class="col-12">
        <div class="card card-teal card-outline card-outline-tabs">  
            
            <div class="card-header p-0 border-bottom-0">
                <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-four-home" role="tab" aria-controls="custom-tabs-four-home" aria-selected="true">Dados Cadastrais</a>
                    </li>                               
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-redes-tab" data-toggle="pill" href="#custom-tabs-four-redes" role="tab" aria-controls="custom-tabs-four-redes" aria-selected="false">Imagens</a>
                    </li>                    
                </ul>
            </div>
            
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="row mb-2">
                                    <div class="col-12 col-md-4">
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Título do Anúncio:</b></label>
                                            <input class="form-control" name="titulo" value="{{old('titulo')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Empresa:</b></label>
                                            <select class="form-control" name="empresa">
                                                @if (!empty($empresas) && $empresas->count() > 0)
                                                    <option value="">Selecione a Empresa</option>
                                                    @foreach($empresas as $empresa)
                                                        <option value="{{ $empresa->id }}" {{ (old('empresa') == $empresa->id ? 'selected' : '') }}>{{ $empresa->alias_name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">Cadastre uma Empresa</option>
                                                @endif                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Plano:</b></label>
                                            <select class="form-control" name="plan_id">
                                                @if (!empty($plans) && $plans->count() > 0)
                                                    <option value="">Selecione o Plano</option>
                                                    @foreach($plans as $plan)
                                                        <option value="{{ $plan->id }}" {{ (old('plan_id') == $plan->id ? 'selected' : '') }}>{{ $plan->name }}</option>
                                                    @endforeach
                                                @else
                                                    <option value="">Cadastre um Plano</option>
                                                @endif                                                
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Posição:</b></label>
                                            <select class="form-control" name="posicao">
                                                <option value="1">Home Sidebar 300x250</option>
                                                <option value="2">Topo home 728x90</option>
                                                <option value="3">Artigo Sidebar 300x250</option>
                                                <option value="4">Notícia Sidebar 300x250</option>
                                                <option value="5">Home Main Footer 728x90</option>
                                                <option value="6">Notícia Main Footer 728x90</option>
                                                <option value="7">Blog Main Footer 728x90</option>
                                                <option value="8">Boletim das Ondas Sidebar 300x250</option>
                                                <option value="9">Home Main Center 728x90</option>
                                                <option value="10">Artigo Main Footer 728x90</option>
                                            </select>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>                   
                        </div>                   
                    </div> 

                    <div class="tab-pane fade" id="custom-tabs-four-redes" role="tabpanel" aria-labelledby="custom-tabs-four-redes-tab">
                        <div class="row mb-2 text-muted">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <h5><b>Banners</b></h5>  
                                    <p>Aqui você configurar as imagens do anúncio, fique atento ao tamanho das imagens para uma melhor experiência da sua aplicação.</p>                                          
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 col-md-6 col-sm-6 col-lg-6"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Banner</b> - 300x250 pixels</label>
                                    <div class="thumb_user_admin">                                                    
                                        <img width="300" height="250" id="preview1" src="{{url(asset('backend/assets/images/image.jpg'))}}" alt="{{ old('titulo') }}" title="{{ old('titulo') }}"/>
                                        <input id="img-300x250" type="file" name="300x250">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-sm-6 col-lg-6"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Banner</b> - 468x90 pixels</label>
                                    <div class="thumb_user_admin">                                                    
                                        <img width="468" height="90" id="preview2" src="{{url(asset('backend/assets/images/image.jpg'))}}" alt="{{ old('titulo') }}" title="{{ old('titulo') }}"/>
                                        <input id="img-468x90" type="file" name="468x90">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-sm-6 col-lg-6"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Banner</b> - 336x280 pixels</label>
                                    <div class="thumb_user_admin">                                                    
                                        <img width="336" height="280" id="preview3" src="{{url(asset('backend/assets/images/image.jpg'))}}" alt="{{ old('titulo') }}" title="{{ old('titulo') }}"/>
                                        <input id="img-336x280" type="file" name="336x280">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-sm-6 col-lg-6"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Banner</b> - 728x90 pixels</label>
                                    <div class="thumb_user_admin">                                                    
                                        <img width="728" height="90" id="preview4" src="{{url(asset('backend/assets/images/image.jpg'))}}" alt="{{ old('titulo') }}" title="{{ old('titulo') }}"/>
                                        <input id="img-728x90" type="file" name="728x90">
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>
                
                    <div class="row text-right">
                        <div class="col-12 mb-4 mt-4">
                            <button type="submit" class="btn btn-success"><i class="nav-icon fas fa-check mr-2"></i> Cadastrar Agora</button>
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
<link rel="stylesheet" href="{{url(asset('backend/plugins/jquery-tags-input/jquery.tagsinput.css'))}}" /> 
<style>
    div.tagsinput span.tag {
        background: #65CEA7 !important;
        border-color: #65CEA7;
        color: #fff;
        border-radius: 15px;
        -webkit-border-radius: 15px;
        padding: 3px 10px;
    }
    div.tagsinput span.tag a {
        color: #43886e;    
    }
    /* Foto User Admin */
    .thumb_user_admin{
    border: 1px solid #ddd;
    border-radius: 4px; 
    text-align: center;
    }
    .thumb_user_admin input[type=file]{
        width: 100%;
        height: 100%;
        position: absolute;
        left: 0;
        top: 0;
        opacity: 0;
    }
    .thumb_user_admin img{
        width: 100%;            
    }
</style>
@stop

@section('js')
<script src="{{url(asset('backend/plugins/jquery-tags-input/jquery.tagsinput.js'))}}"></script>
<script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
<script>
    $(document).ready(function () { 
        var $Cpf = $(".cpfmask");
        $Cpf.mask('000.000.000-00', {reverse: true});
        var $Cnpj = $(".cnpjmask");
        $Cnpj.mask('00.000.000/0000-00', {reverse: true});
        var $whatsapp = $(".whatsappmask");
        $whatsapp.mask('(99) 99999-9999', {reverse: false});
        var $telefone = $(".telefonemask");
        $telefone.mask('(99) 9999-9999', {reverse: false});
        var $celularmask = $(".celularmask");
        $celularmask.mask('(99) 99999-9999', {reverse: false});
        var $zipcode = $(".mask-zipcode");
        $zipcode.mask('00.000-000', {reverse: true});
    });
</script> 
<script>
    $(function () { 

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        function readImage300x250() {
            if (this.files && this.files[0]) {
                var file = new FileReader();
                file.onload = function(e) {
                    document.getElementById("preview1").src = e.target.result;
                };       
                file.readAsDataURL(this.files[0]);
            }
        }

        function readImage468x90() {
            if (this.files && this.files[0]) {
                var file = new FileReader();
                file.onload = function(e) {
                    document.getElementById("preview2").src = e.target.result;
                };       
                file.readAsDataURL(this.files[0]);
            }
        }

        function readImage336x280() {
            if (this.files && this.files[0]) {
                var file = new FileReader();
                file.onload = function(e) {
                    document.getElementById("preview3").src = e.target.result;
                };       
                file.readAsDataURL(this.files[0]);
            }
        }

        function readImage728x90() {
            if (this.files && this.files[0]) {
                var file = new FileReader();
                file.onload = function(e) {
                    document.getElementById("preview4").src = e.target.result;
                };       
                file.readAsDataURL(this.files[0]);
            }
        }
        
        document.getElementById("img-300x250").addEventListener("change", readImage300x250, false);
        document.getElementById("img-468x90").addEventListener("change", readImage468x90, false);
        document.getElementById("img-336x280").addEventListener("change", readImage336x280, false);
        document.getElementById("img-728x90").addEventListener("change", readImage728x90, false);
        
        //tag input
        function onAddTag(tag) {
            alert("Adicionar uma Tag: " + tag);
        }
        function onRemoveTag(tag) {
            alert("Remover Tag: " + tag);
        }
        function onChangeTag(input,tag) {
            alert("Changed a tag: " + tag);
        }
        $(function() {
            $('#tags_1').tagsInput({
                width:'auto',
                height:200
            });
        }); 

    });
</script>
@endsection