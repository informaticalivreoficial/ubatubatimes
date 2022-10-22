@extends('adminlte::page')

@section('title', 'Editar Empresa')

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
        <h1><i class="fas fa-search mr-2"></i>Editar Empresa</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('empresas.index')}}">Empresas</a></li>
            <li class="breadcrumb-item active">Editar Empresa</li>
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
        
<form action="{{ route('empresas.update', $empresa->id) }}" method="post" enctype="multipart/form-data">
@csrf
@method('PUT')  
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
                                                <input id="clientesim" class="form-check-input" type="radio" value="1" name="cliente" {{(old('cliente') == '1' ? 'checked' : ($empresa->cliente == '1' ? 'checked' : ''))}}>
                                                <label for="clientesim" class="form-check-label mr-5">Sim</label>
                                                <input id="clientenao" class="form-check-input" type="radio" value="0" name="cliente" {{(old('cliente') == '0' ? 'checked' : ($empresa->cliente == '0' ? 'checked' : ''))}}>
                                                <label for="clientenao" class="form-check-label">Não</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Responsável Legal:</b></label>
                                            <input type="text" class="form-control" name="responsavel" value="{{ old('responsavel') ?? $empresa->responsavel }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Responsável Email:</b></label>
                                            <input type="text" class="form-control" name="responsavel_email" value="{{ old('responsavel_email') ?? $empresa->responsavel_email }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>CPF</b></label>
                                            <input type="text" class="form-control cpfmask" name="responsavel_cpf" value="{{ old('responsavel_cpf') ?? $empresa->responsavel_cpf }}"/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Categoria:</b></label>
                                            @if (!empty($categorias) && $categorias->count() > 0)
                                                <select class="form-control j_category" name="cat_pai">
                                                    <option value="">Selecione a Categoria</option>
                                                    @foreach ($categorias as $categoria)
                                                    <option value="{{$categoria->id}}" {{ (old('cat_pai') == $categoria->id ? 'selected' : ($empresa->cat_pai == $categoria->id ? 'selected' : '')) }}>{{$categoria->titulo}}</option>
                                                    @endforeach
                                                </select>                                            
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Sub-categoria:</b></label>
                                            <select class="form-control j_subcategory" name="categoria">
                                                @if(!empty($categorias) && !empty($empresa->categoria))
                                                    @foreach($categorias as $cat)
                                                        @if ($cat->children)
                                                            @foreach ($cat->children as $subcat)
                                                                <option value="{{$subcat->id}}" {{ (old('categoria') == $subcat->id ? 'selected' : ($empresa->categoria == $subcat->id ? 'selected' : '')) }}>{{$subcat->titulo}}</option>
                                                            @endforeach                                                        
                                                        @endif                                                    
                                                    @endforeach 
                                                @else
                                                    <option value="">Selecione a Categoria</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Exibir no Guia?</b></label>
                                            <select name="exibirnoguia" class="form-control">
                                                <option value="1" {{ (old('exibirnoguia') == '1' ? 'selected' : ($empresa->exibirnoguia == 1 ? 'selected' : '')) }}>Sim</option>
                                                <option value="0" {{ (old('exibirnoguia') == '0' ? 'selected' : ($empresa->exibirnoguia == 0 ? 'selected' : '')) }}>Não</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <div class="thumb_user_admin">
                                        @php
                                            if(!empty($empresa->logomarca) && \Illuminate\Support\Facades\Storage::exists($empresa->logomarca)){
                                                $cover = $empresa->logoCover();
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
                                            <input type="text" class="form-control" placeholder="Nome Fantasia" name="alias_name" value="{{ old('alias_name') ?? $empresa->alias_name }}">
                                        </div>
                                    </div>                                 
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Razão Social:</b></label>
                                            <input type="text" class="form-control" placeholder="Razão Social" name="social_name" value="{{ old('social_name') ?? $empresa->social_name }}">
                                        </div>
                                    </div>                                    
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>CNPJ:</b></label>
                                            <input type="text" class="form-control cnpjmask" placeholder="CNPJ da Empresa" name="document_company" value="{{ old('document_company') ?? $empresa->document_company }}"/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Inscrição Estadual:</b></label>
                                            <input type="text" class="form-control" placeholder="Número da Inscrição" name="document_company_secondary" value="{{ old('document_company_secondary') ?? $empresa->document_company_secondary }}"/>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Email:</b></label>
                                            <input type="text" class="form-control" name="email" value="{{old('email') ?? $empresa->email}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Telefone Fixo:</b></label>
                                            <input type="text" class="form-control telefonemask" name="telefone" value="{{old('telefone') ?? $empresa->telefone}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Celular:</b></label>
                                            <input type="text" class="form-control celularmask" name="celular" value="{{old('celular') ?? $empresa->celular}}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>WhatsApp:</b></label>
                                            <input type="text" class="form-control whatsappmask" name="whatsapp" value="{{old('whatsapp') ?? $empresa->whatsapp}}">
                                        </div>
                                    </div>
                                </div>
                            </div>                            
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Estado:</b></label>
                                    <select id="state-dd" class="form-control" name="uf">
                                        @if(!empty($estados))
                                            <option value="">Selecione o Estado</option>
                                            @foreach($estados as $estado)
                                                <option value="{{$estado->estado_id}}" {{ (old('uf') == $estado->estado_id ? 'selected' : ($empresa->uf == $estado->estado_id ? 'selected' : '')) }}>{{$estado->estado_nome}}</option>
                                            @endforeach                                                                        
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Cidade:</b></label>
                                    <select id="city-dd" class="form-control" name="cidade">
                                        @if(!empty($cidades)))
                                            <option value="">Selecione o Estado</option>
                                            @foreach($cidades as $cidade)
                                                <option value="{{$cidade->cidade_id}}" {{ (old('cidade') == $cidade->cidade_id ? 'selected' : ($cidade->cidade_id == $empresa->cidade ? 'selected' : '')) }}>{{$cidade->cidade_nome}}</option>                                                                   
                                            @endforeach                                                                        
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Bairro:</b></label>
                                    <input type="text" class="form-control" placeholder="Bairro" name="bairro" value="{{old('bairro') ?? $empresa->bairro}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 col-md-6 col-lg-5"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Endereço:</b></label>
                                    <input type="text" class="form-control" name="rua" value="{{old('rua') ?? $empresa->rua}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*Número:</b></label>
                                    <input type="text" class="form-control" name="num" value="{{old('num') ?? $empresa->num}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Complemento:</b></label>
                                    <input type="text" class="form-control" name="complemento" value="{{old('complemento') ?? $empresa->complemento}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>*CEP:</b></label>
                                    <input type="text" class="form-control mask-zipcode" name="cep" value="{{old('cep') ?? $empresa->cep}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">   
                                <label class="labelforms"><b>Conteúdo:</b></label>
                                <x-adminlte-text-editor name="content" v placeholder="Conteúdo do post..." :config="$config">{{ old('content') ?? $empresa->content }}</x-adminlte-text-editor>                                                      
                            </div>
                        </div> 
                        <div class="row mb-2">
                            <div class="col-12">   
                                <label class="labelforms text-muted"><b>Informações Adicionais</b></label>
                                <textarea id="inputDescription" class="form-control" rows="5" name="notasadicionais">{{ old('notasadicionais') ?? $empresa->notasadicionais }}</textarea>                                                      
                            </div>                                
                        </div>                           
                    </div>
                    
                    <div class="tab-pane fade" id="custom-tabs-four-imagens" role="tabpanel" aria-labelledby="custom-tabs-four-imagens-tab">
                        <div class="row mb-4">
                            <div class="col-sm-12">                                        
                                <div class="form-group">
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="exampleInputFile" name="files[]" multiple>
                                        <label class="custom-file-label" for="exampleInputFile">Escolher Imagens</label>
                                    </div>
                                </div>                                        
                                <div class="content_image"></div> 
                                                        
                                <div class="property_image">
                                    @foreach($empresa->images()->get() as $image)
                                    <div class="property_image_item">
                                        <a href="{{ $image->getUrlImageAttribute() }}" data-toggle="lightbox" data-gallery="property-gallery" data-type="image">
                                        <img src="{{ $image->url_cropped }}" alt="">
                                        </a>
                                        <div class="property_image_actions">
                                            <a href="javascript:void(0)" class="btn btn-xs {{ ($image->cover == true ? 'btn-success' : 'btn-default') }} icon-notext image-set-cover px-2" data-action="{{ route('empresas.imageSetCover', ['image' => $image->id]) }}"><i class="nav-icon fas fa-check"></i> </a>
                                            <a href="javascript:void(0)" class="btn btn-danger btn-xs image-remove px-2" data-action="{{ route('empresas.imageRemove', ['image' => $image->id]) }}"><i class="nav-icon fas fa-times"></i> </a>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
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
                                    <input type="text" class="form-control text-muted" placeholder="Facebook" name="facebook" value="{{old('facebook') ?? $empresa->facebook}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Twitter:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Twitter" name="twitter" value="{{old('twitter') ?? $empresa->twitter}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Youtube:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Youtube" name="youtube" value="{{old('youtube') ?? $empresa->youtube}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Flickr:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Flickr" name="fliccr" value="{{old('fliccr') ?? $empresa->fliccr}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Instagram:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Instagram" name="instagram" value="{{old('instagram') ?? $empresa->instagram}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Vimeo:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Vimeo" name="vimeo" value="{{old('vimeo') ?? $empresa->vimeo}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Linkedin:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Linkedin" name="linkedin" value="{{old('linkedin') ?? $empresa->linkedin}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Sound Cloud:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Linkedin" name="soundclound" value="{{old('soundclound') ?? $empresa->soundclound}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>SnapChat:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="SnapChat" name="snapchat" value="{{old('snapchat') ?? $empresa->snapchat}}">
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
                                    <input type="text" class="form-control" name="dominio" value="{{ old('dominio') ?? $empresa->dominio }}">
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Ano de início</b> </label>
                                    <input type="text" class="form-control" name="ano_de_inicio" value="{{ old('ano_de_inicio') ?? $empresa->ano_de_inicio }}">
                                </div>
                            </div>
                            <div class="col-12 mb-1"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>MetaTags</b></label>
                                    <input id="tags_1" class="tags" rows="5" name="metatags" value="{{ old('metatags') ?? $empresa->metatags }}">
                                </div>
                            </div>
                            <div class="col-12 mb-1">   
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Mapa do Google</b> <small class="text-info">(Copie o código de incorporação do Google Maps e cole abaixo)</small></label>
                                    <textarea id="inputDescription" class="form-control" rows="5" name="mapa_google">{{ old('mapa_google') ?? $empresa->mapa_google }}</textarea> 
                                </div>                                                     
                            </div>
                            <div class="col-12 mb-1"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Meta Imagem: </b>(800X418) pixels</label>
                                    <div class="thumb_user_admin">                                                    
                                        <img style="max-height: 418px;" id="preview1" src="{{$empresa->getmetaimg()}}" alt="{{ old('dominio') }}" title="{{ old('dominio') }}"/>
                                        <input id="img-metaimg" type="file" name="metaimg">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-four-anuncios" role="tabpanel" aria-labelledby="custom-tabs-four-anuncios-tab">
                        <div class="col-sm-12">
                            <div class="form-group text-muted">
                                <h5><b>Anúncios</b></h5>               
                            </div>
                        </div>
                        @if (!empty($anuncios) && $anuncios->count() > 0)
                            <table id="example1" class="table table-bordered table-striped projects">
                                <thead>
                                    <tr class="text-muted">
                                        <th>Posição</th>
                                        <th>Criado</th>
                                        <th>Expira</th>
                                        <th>Situação</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($anuncios as $anuncio)
                                        <tr>
                                            <td>{{$anuncio->posicao}}</td>
                                            <td>{{$anuncio->created_at}}</td>
                                            <td></td>
                                            <td>{{($anuncio->status == 1 ? 'Ativo' : 'Inativo')}}</td>
                                            <td>
                                                <a href="{{route('anuncios.edit',['id' => $anuncio->id])}}" class="btn btn-xs btn-default"><i class="fas fa-pen"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>

                    <div class="tab-pane fade" id="custom-tabs-four-faturas" role="tabpanel" aria-labelledby="custom-tabs-four-faturas-tab">
                        
                    </div>
                
                    <div class="row text-right">
                        <div class="col-12 mb-4 mt-4">
                            <button type="submit" class="btn btn-success"><i class="nav-icon fas fa-check mr-2"></i> Atualizar Agora</button>
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
    /* Foto User Admin */
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
    img {
        max-width: 100%;
    }
    .realty_list_item  {    
        border: 1px solid #F3F3F3;
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
    }

    .border-item-imovel{
        -webkit-border-radius: 4px;
        -moz-border-radius: 4px;
        border-radius: 4px;
        border: 1px solid #F3F3F3;  
        background-color: #F3F3F3;
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

        $(document).ready(function() {  
            $(".j_subcategory").on('input',function(e) {
                if($(this).val() !== '') {
                    $(".j_subcategory").removeAttr('disabled');
                } else {
                    $(".j_subcategory").attr('disabled', true);
                }
            });
        });

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
                    $.each(res.values, function (key, value) {
                        $('.j_subcategory').append('<option value="' + value.id + '">' + value.titulo + '</option>');
                    });
                }
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

        $('#state-dd').on('change', function () {
            var idState = this.value;
            $("#city-dd").html('Carregando...');
            $.ajax({
                url: "{{route('empresas.fetchCity')}}",
                type: "POST",
                data: {
                    estado_id: idState,
                    _token: '{{csrf_token()}}'
                },
                dataType: 'json',
                success: function (res) {
                    $('#city-dd').html('<option value="">Selecione a cidade</option>');
                    $.each(res.cidades, function (key, value) {
                        $("#city-dd").append('<option value="' + value
                            .cidade_id + '">' + value.cidade_nome + '</option>');
                    });
                }
            });
        });

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

        $('input[name="files[]"]').change(function (files) {
            $('.content_image').text('');
            $.each(files.target.files, function (key, value) {
                var reader = new FileReader();
                reader.onload = function (value) {
                    $('.content_image').append(
                        '<div id="list" class="property_image_item">' +
                        '<div class="embed radius" style="background-image: url(' + value.target.result + '); background-size: cover; background-position: center center;"></div>' +
                        '<div class="property_image_actions">' +
                            '<a href="javascript:void(0)" class="btn btn-danger btn-xs image-remove1 px-2"><i class="nav-icon fas fa-times"></i> </a>' +
                        '</div>' +
                        '</div>');
                        
                    $('.image-remove1').click(function(){
                        $(this).closest('#list').remove()
                    });
                };
                reader.readAsDataURL(value);
            });
        }); 

        $('.image-set-cover').click(function (event) {
            event.preventDefault();
            var button = $(this);
            $.post(button.data('action'), {}, function (response) {
                if (response.success === true) {
                    $('.property_image').find('a.btn-success').removeClass('btn-success');
                    button.addClass('btn-success');
                }
                if(response.success === false){
                    button.addClass('btn-default');
                }
            }, 'json');
        });
            
        $('.image-remove').click(function(event){
            event.preventDefault();
            var button = $(this);
            $.ajax({
                url: button.data('action'),
                type: 'DELETE',
                dataType: 'json',
                success: function(response){
                    if(response.success === true) {
                        button.closest('.property_image_item').fadeOut(function(){
                            $(this).remove();
                        });
                    }
                }
            });
        });
            
        $(document).on('click', '[data-toggle="lightbox"]', function(event) {
            event.preventDefault();
            $(this).ekkoLightbox({
            alwaysShowClose: true
            });
        });

    });
</script>
@endsection