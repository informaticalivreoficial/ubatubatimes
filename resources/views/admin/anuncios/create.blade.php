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
                            <div class="col-12">
                                <div class="row mb-2">                                    
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Categoria:</b></label>
                                            @if (!empty($categorias) && $categorias->count() > 0)
                                                <select class="form-control j_category" name="cat_pai">
                                                    <option value="">Selecione a Categoria</option>
                                                    @foreach ($categorias as $categoria)
                                                    <option value="{{$categoria->id}}" {{ (old('cat_pai') == $categoria->cat_pai ? 'selected' : '') }}>{{$categoria->titulo}}</option>
                                                    @endforeach
                                                </select>                                            
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Sub-categoria:</b></label>
                                            <select class="form-control j_subcategory" name="categoria">
                                                <option value="">Selecione a Categoria</option>
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
                                        <img id="preview1" src="" alt="" title=""/>
                                        <input id="img-300x250" type="file" name="300x250">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-sm-6 col-lg-6"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Logomarca do Gerenciador</b> - {{env('LOGOMARCA_GERENCIADOR_WIDTH')}}x{{env('LOGOMARCA_GERENCIADOR_HEIGHT')}} pixels</label>
                                    <div class="thumb_user_admin">                                                    
                                        <img id="preview3" src="" alt="{{ old('dominio')  }}" title="{{ old('dominio')  }}"/>
                                        <input id="img-logomarcaadmin" type="file" name="logomarca_admin">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-sm-6 col-lg-6"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Favicon</b> - {{env('FAVEICON_WIDTH')}}x{{env('FAVEICON_HEIGHT')}} pixels</label>
                                    <div class="thumb_user_admin">                                                    
                                        <img id="preview4" src="" alt="{{ old('dominio')  }}" title="{{ old('dominio')  }}"/>
                                        <input id="img-favicon" type="file" name="favicon">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-sm-6 col-lg-6"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Marca D´agua</b> - {{env('MARCADAGUA_WIDTH')}}x{{env('MARCADAGUA_HEIGHT')}} pixels</label>
                                    <div class="thumb_user_admin">                                                    
                                        <img id="preview5" src="" alt="{{ old('dominio')  }}" title="{{ old('dominio')  }}"/>
                                        <input id="img-marcadagua" type="file" name="marcadagua">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Topo do site</b> - {{env('IMGHEADER_WIDTH')}}x{{env('IMGHEADER_HEIGHT')}} pixels</label>
                                    <div class="thumb_user_admin">
                                        <img id="preview6" src="" alt="{{ old('dominio')  }}" title="{{ old('dominio')  }}"/>
                                        <input id="img-imgheader" type="file" name="imgheader">
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

        $('.j_subcategory').attr('disabled', true);
        $('.j_category').on('change', function () {
            var idCategoria = this.value;
            $('.j_subcategory').html('Carregando...');
            $.ajax({
                url: "{{route('anuncios.categorias.fetchSubcategorias')}}",
                type: "POST",
                data: {
                    cat_id: idCategoria,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('.j_subcategory').html('<option value="">Selecione a sub-categoria</option>');
                    $('.j_subcategory').attr('disabled', false);
                    $.each(res.values, function (key, value) {
                        $('.j_subcategory').append('<option value="' + value.id + '">' + value.titulo + '</option>');
                    });
                }
            });
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
        
        document.getElementById("img-300x250").addEventListener("change", readImage300x250, false);

        



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