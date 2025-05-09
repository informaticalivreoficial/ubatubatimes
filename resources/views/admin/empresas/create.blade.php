@extends('adminlte::page')

@section('title', 'Cadastrar Empresa')

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
        <h1><i class="fas fa-search mr-2"></i>Nova Empresa</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('empresas.index')}}">Empresas</a></li>
            <li class="breadcrumb-item active">Nova Empresa</li>
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
        
<form action="{{route('empresas.store')}}" method="post" enctype="multipart/form-data">
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
                        <a class="nav-link" id="custom-tabs-four-imagens-tab" data-toggle="pill" href="#custom-tabs-four-imagens" role="tab" aria-controls="custom-tabs-four-imagens" aria-selected="false">Imagens</a>
                    </li>                            
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-redes-tab" data-toggle="pill" href="#custom-tabs-four-redes" role="tab" aria-controls="custom-tabs-four-redes" aria-selected="false">Redes Sociais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-seo-tab" data-toggle="pill" href="#custom-tabs-four-seo" role="tab" aria-controls="custom-tabs-four-seo" aria-selected="false">SEO</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-anuncioa-tab" data-toggle="pill" href="#custom-tabs-four-anuncios" role="tab" aria-controls="custom-tabs-four-anuncios" aria-selected="false">Anúncios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-faturas-tab" data-toggle="pill" href="#custom-tabs-four-faturas" role="tab" aria-controls="custom-tabs-four-faturas" aria-selected="false">Faturas</a>
                    </li>
                </ul>
            </div>
            
            <div class="card-body">
                <div class="tab-content" id="custom-tabs-four-tabContent">
                    <div class="tab-pane fade show active" id="custom-tabs-four-home" role="tabpanel" aria-labelledby="custom-tabs-four-home-tab">
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="row mb-4">
                                    <div class="col-12"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Cliente? </b></label>
                                            <div class="form-check">
                                                <input id="clientesim" class="form-check-input" type="radio" value="1" name="cliente" {{(old('cliente') == '1' ? 'checked' : '')}}>
                                                <label for="clientesim" class="form-check-label mr-5">Sim</label>
                                                <input id="clientenao" class="form-check-input" type="radio" value="0" name="cliente" {{(old('cliente') == '0' ? 'checked' : '')}}>
                                                <label for="clientenao" class="form-check-label">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Responsável Legal:</b></label>
                                            <input type="text" class="form-control" name="responsavel" value="{{ old('responsavel') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Responsável Email:</b></label>
                                            <input type="text" class="form-control" name="responsavel_email" value="{{ old('responsavel_email') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>CPF</b></label>
                                            <input type="text" class="form-control cpfmask" name="responsavel_cpf" value="{{ old('responsavel_cpf') }}"/>
                                        </div>
                                    </div>
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
                                            @else 
                                                <p>Cadastre uma Categoria</p>                                         
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
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Exibir no Guia?</b></label>
                                            <select name="exibirnoguia" class="form-control">
                                                <option value="1" {{ (old('exibirnoguia') == '1' ? 'selected' : '') }}>Sim</option>
                                                <option value="0" {{ (old('exibirnoguia') == '0' ? 'selected' : '') }}>Não</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <div class="thumb_user_admin">
                                        @php
                                            if(!empty($empresa->logomarca) && \Illuminate\Support\Facades\File::exists(public_path() . '/storage/' . $empresa->logomarca)){
                                                $cover = url('storage/'.$empresa->logomarca);
                                            } else {
                                                $cover = url(asset('backend/assets/images/image.jpg'));
                                            }
                                        @endphp
                                        <img id="preview" src="{{$cover}}" alt="{{ old('alias_name') }}" title="{{ old('alias_name') }}"/>
                                        <input id="img-logomarca" type="file" name="logomarca">
                                    </div>                                                
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-8">
                                <div class="row mb-2">                                    
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Nome Fantasia:</b></label>
                                            <input type="text" class="form-control" name="alias_name" value="{{ old('alias_name') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Razão Social:</b></label>
                                            <input type="text" class="form-control" name="social_name" value="{{ old('social_name') }}">
                                        </div>
                                    </div>                                    
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>CNPJ:</b></label>
                                            <input type="text" class="form-control cnpjmask" name="document_company" value="{{ old('document_company') }}"/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Inscrição Estadual:</b></label>
                                            <input type="text" class="form-control" name="document_company_secondary" value="{{ old('document_company_secondary') }}"/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Email:</b></label>
                                            <input type="text" class="form-control" name="email" value="{{old('email')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Telefone Fixo:</b></label>
                                            <input type="text" class="form-control telefonemask" name="telefone" value="{{old('telefone')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Celular:</b></label>
                                            <input type="text" class="form-control celularmask" name="celular" value="{{old('celular')}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>WhatsApp:</b></label>
                                            <input type="text" class="form-control whatsappmask" name="whatsapp" value="{{old('whatsapp')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 col-md-2 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>CEP:</b></label>
                                    <input type="text" id="cep" class="form-control mask-zipcode" placeholder="Digite o CEP" name="cep" value="{{old('cep')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-3 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Estado:</b></label>
                                    <input type="text" class="form-control" id="uf" name="uf" value="{{old('uf')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Cidade:</b></label>
                                    <input type="text" class="form-control" id="cidade" name="cidade" value="{{old('cidade')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Bairro:</b></label>
                                    <input type="text" class="form-control" placeholder="Bairro" id="bairro" name="bairro" value="{{old('bairro')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 col-md-6 col-lg-5"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Rua/Av:</b></label>
                                    <input type="text" class="form-control" id="rua" name="rua" value="{{old('rua')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Número:</b></label>
                                    <input type="text" class="form-control" placeholder="Número do Endereço" name="num" value="{{old('num')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Complemento:</b></label>
                                    <input type="text" class="form-control" placeholder="Complemento (Opcional)" name="complemento" value="{{old('complemento')}}">
                                </div>
                            </div>
                        </div>    
                        <div class="row">
                            <div class="col-12">   
                                <label class="labelforms"><b>Conteúdo:</b></label>
                                <x-adminlte-text-editor name="content" v placeholder="Conteúdo do post..." :config="$config">{{ old('content') }}</x-adminlte-text-editor>                                                      
                            </div>
                        </div>               
                        <div class="row mb-2">
                            <div class="col-12">   
                                <label class="labelforms text-muted"><b>Informações Adicionais</b></label>
                                <textarea id="inputDescription" class="form-control" rows="5" name="notasadicionais">{{ old('notasadicionais') }}</textarea>                                                      
                            </div>                                
                        </div>                           
                    </div> 

                    <div class="tab-pane fade" id="custom-tabs-four-imagens" role="tabpanel" aria-labelledby="custom-tabs-four-imagens-tab">
                        <div class="row mb-4">
                            <div class="col-sm-12">                                        
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="files[]" multiple>
                                        <label class="custom-file-label" for="exampleInputFile">Escolher Fotos</label>
                                    </div>
                                </div>                                        
                                <div class="content_image"></div>
                            </div>
                        </div> 
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-four-redes" role="tabpanel" aria-labelledby="custom-tabs-four-redes-tab">
                        <div class="row mb-2 text-muted">
                            <div class="col-sm-12 text-muted">
                                <div class="form-group">
                                    <h5><b>Redes Sociais</b></h5>            
                                </div>
                            </div>
                            <hr>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Facebook:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Facebook" name="facebook" value="{{old('facebook')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Twitter:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Twitter" name="twitter" value="{{old('twitter')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Youtube:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Youtube" name="youtube" value="{{old('youtube')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Flickr:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Flickr" name="fliccr" value="{{old('fliccr')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Instagram:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Instagram" name="instagram" value="{{old('instagram')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Vimeo:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Vimeo" name="vimeo" value="{{old('vimeo')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Linkedin:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Linkedin" name="linkedin" value="{{old('linkedin')}}">
                                </div>
                            </div>                            
                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-four-seo" role="tabpanel" aria-labelledby="custom-tabs-four-seo-tab">
                        <div class="row mb-2 text-muted">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <h5><b>Configurações SEO</b></h5>  
                                    <p>Aqui você pode configurar a otimização para as aplicações de Buscas</p>                                          
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Url</b> </label>
                                    <input type="text" class="form-control" name="dominio" value="{{ old('dominio') }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Ano de início</b> </label>
                                    <input type="text" class="form-control" name="ano_de_inicio" value="{{ old('ano_de_inicio') }}">
                                </div>
                            </div>
                            <div class="col-12 mb-1"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>MetaTags</b></label>
                                    <input id="tags_1" class="tags" rows="5" name="metatags" value="{{ old('metatags') }}">
                                </div>
                            </div>
                            <div class="col-12 mb-1">   
                                <div class="form-group">
                                    <label class="labelforms"><b>Mapa do Google</b> <small class="text-info">(Copie o código de incorporação do Google Maps e cole abaixo)</small></label>
                                    <textarea id="inputDescription" class="form-control" rows="5" name="mapa_google">{{ old('mapa_google') }}</textarea> 
                                </div>                                                     
                            </div>
                            <div class="col-12 mb-1"> 
                                <div class="form-group">
                                    <label class="labelforms"><b>Meta Imagem: </b>(800X418) pixels</label>
                                    <div class="thumb_user_admin">                                                    
                                        <img style="max-height: 418px;" id="preview1" src="{{url(asset('backend/assets/images/image.jpg'))}}" alt="{{ old('dominio') }}" title="{{ old('dominio') }}"/>
                                        <input id="img-metaimg" type="file" name="metaimg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-four-anuncios" role="tabpanel" aria-labelledby="custom-tabs-four-anuncios-tab">
                        
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-four-faturas" role="tabpanel" aria-labelledby="custom-tabs-four-faturas-tab">
                        
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
    .property_image, .content_image {
            width: 100%;
            flex-basis: 100%;
            display: flex;
            justify-content: flex-start;
            flex-wrap: wrap;
        }
        .property_image .property_image_item, .content_image .property_image_item {
            flex-basis: calc(25% - 20px) !important;
            margin-bottom: 20px;
            margin-right: 20px;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            position: relative;
        }

        .property_image .property_image_item img, .content_image .property_image_item img {
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
        }
        .property_image .property_image_item .property_image_actions, .content_image .property_image_item .property_image_actions {
            position: absolute;
            top: 10px;
            left: 10px;
        }

        .embed {
            position: relative;
            padding-bottom: 56.25%;
            height: 0;
            overflow: hidden;
            max-width: 100%;
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

        $('input[name="files[]"]').change(function (files) {

            $('.content_image').text('');

            $.each(files.target.files, function (key, value) {
                var reader = new FileReader();
                reader.onload = function (value) {
                    $('.content_image').append(
                        '<div id="list" class="property_image_item">' +
                        '<div class="embed radius" style="background-image: url(' + value.target.result + '); background-size: cover; background-position: center center;"></div>' +
                        '<div class="property_image_actions">' +
                            '<a href="javascript:void(0)" class="btn btn-danger btn-xs image-remove px-2"><i class="nav-icon fas fa-times"></i> </a>' +
                        '</div>' +
                        '</div>');

                    $('.image-remove').click(function(){
                        $(this).closest('#list').remove()
                    });
                };
                reader.readAsDataURL(value);
            });
        });

        function readImage() {
            if (this.files && this.files[0]) {
                var file = new FileReader();
                file.onload = function(e) {
                    document.getElementById("preview").src = e.target.result;
                };       
                file.readAsDataURL(this.files[0]);
            }
        }

        $('.j_subcategory').attr('disabled', true);
        $('.j_category').on('change', function () {
            var idCategoria = this.value;
            $('.j_subcategory').html('Carregando...');
            $.ajax({
                url: "{{route('empresas.categorias.fetchSubcategorias')}}",
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

        function readImageMetaImagem() {
            if (this.files && this.files[0]) {
                var file = new FileReader();
                file.onload = function(e) {
                    document.getElementById("preview1").src = e.target.result;
                };       
                file.readAsDataURL(this.files[0]);
            }
        }
        document.getElementById("img-metaimg").addEventListener("change", readImageMetaImagem, false);
        document.getElementById("img-logomarca").addEventListener("change", readImage, false);

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

    $(document).ready(function() {

        function limpa_formulário_cep() {
            $("#rua").val("");
            $("#bairro").val("");
            $("#cidade").val("");
            $("#uf").val("");
        }

        $("#cep").blur(function() {

            var cep = $(this).val().replace(/\D/g, '');

            if (cep != "") {
                
                var validacep = /^[0-9]{8}$/;

                if(validacep.test(cep)) {
                    
                    $("#rua").val("Carregando...");
                    $("#bairro").val("Carregando...");
                    $("#cidade").val("Carregando...");
                    $("#uf").val("Carregando...");
                    
                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                        if (!("erro" in dados)) {
                            $("#rua").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#uf").val(dados.uf);
                        } else {
                            limpa_formulário_cep();
                            alert("CEP não encontrado.");
                        }
                    });
                } else {
                    limpa_formulário_cep();
                    alert("Formato de CEP inválido.");
                }
            } else {
                limpa_formulário_cep();
            }
        });
    });
</script>
@endsection