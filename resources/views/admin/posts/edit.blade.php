@extends('adminlte::page')

@section('title', "Editar $tituloPagina")

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
        <h1>Editar {{$tituloPagina}}</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item"><a href="{{route('posts.'.$tipo)}}">{{$tituloPagina}}s</a></li>
            <li class="breadcrumb-item active">Editar {{$tituloPagina}}</li>
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
        <div class="row">
            <div class="col-12">
                <div class="card card-teal card-outline card-outline-tabs">
                    <div class="card-header p-0 border-bottom-0">
                        <ul class="nav nav-tabs" id="custom-tabs-four-tab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="custom-tabs-four-home-tab" data-toggle="pill" href="#custom-tabs-conteudo" role="tab" aria-controls="custom-tabs-conteudo" aria-selected="true">Conteúdo</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="custom-tabs-four-messages-tab" data-toggle="pill" href="#custom-tabs-imagens" role="tab" aria-controls="custom-tabs-imagens" aria-selected="false">Imagens</a>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <form action="{{ route('posts.update', ['id' => $post->id]) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        @method('PUT')
                        <div class="tab-content" id="custom-tabs-four-tabContent">
                            <div class="tab-pane fade show active" id="custom-tabs-conteudo" role="tabpanel" aria-labelledby="custom-tabs-conteudo-tab">
                                                       
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Título:</b></label>
                                            <input class="form-control" name="titulo" placeholder="Título do Artigo" value="{{old('titulo') ?? $post->titulo}}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Autor:</b></label>
                                            <select class="form-control" name="autor">
                                                <option value="">Selecione o Autor</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}" {{ (old('autor') == $user->id ? 'selected' : ($user->id == $post->autor ? 'selected' : '')) }}>{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Status:</b></label>
                                            <select name="status" class="form-control">
                                                <option value="1" {{ (old('status') == '1' ? 'selected' : ($post->status == 1 ? 'selected' : '')) }}>Publicado</option>
                                                <option value="0" {{ (old('status') == '0' ? 'selected' : ($post->status == 0 ? 'selected' : '')) }}>Rascunho</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="labelforms"><b>*Tipo:</b></label>
                                            <select name="tipo" class="form-control tipo_post">
                                                <option value=""> Selecione </option>
                                                <option value="artigo" {{ (old('artigo') == '1' ? 'selected' : ($post->tipo == 'artigo' ? 'selected' : '')) }}>Artigo</option>
                                                <option value="noticia" {{ (old('noticia') == '0' ? 'selected' : ($post->tipo == 'noticia' ? 'selected' : '')) }}>Notícia</option>
                                                <option value="pagina" {{ (old('pagina') == '0' ? 'selected' : ($post->tipo == 'pagina' ? 'selected' : '')) }}>Página</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label class="labelforms"><b>*Categoria:</b> <a style="font-size:11px;" href="{{route('categorias.index')}}">(Criar categoria)</a></label>
                                            <select name="categoria" class="form-control categoria">
                                                @if(!empty($categorias) && !empty($post->categoria))
                                                    @foreach($categorias as $categoria)
                                                        @if($categoria->tipo == $post->tipo)
                                                            <optgroup label="{{ $categoria->titulo }}">  
                                                                @if($categoria->children)
                                                                    @foreach($categoria->children as $subcategoria)
                                                                        <option value="{{ $subcategoria->id }}" {{ (old('categoria') == $subcategoria->id ? 'selected' : ($subcategoria->id == $post->categoria ? 'selected' : '')) }}>{{ $subcategoria->titulo }}</option>
                                                                    @endforeach
                                                                @endif
                                                            </optgroup>
                                                        @endif 
                                                    @endforeach
                                                @else
                                                    <option value="">Cadastre Categorias</option>
                                                @endif                                             
                                            </select>
                                        </div>
                                    </div>                                    
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Permitir Comentários:</b></label>
                                            <select name="comentarios" class="form-control">
                                                <option value="1" {{ (old('comentarios') == '1' ? 'selected' : ($post->comentarios == 1 ? 'selected' : '')) }}>Sim</option>
                                                <option value="0" {{ (old('comentarios') == '0' ? 'selected' : ($post->comentarios == 0 ? 'selected' : '')) }}>Não</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label class="labelforms"><b>Agendar Publicação:</b></label>
                                            <div class="input-group date">
                                                <input type="text" class="form-control datepicker-here" data-language='pt-BR' name="publish_at" value="{{ old('publish_at') ?? $post->publish_at }}"/>
                                                <div class="input-group-append">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 mb-1"> 
                                        <div class="form-group">
                                            <label class="labelforms"><b>MetaTags:</b></label>
                                            <input id="tags_1" class="tags" rows="5" name="tags" value="{{old('tags') ?? $post->tags}}">
                                        </div>
                                    </div>
                                    <div class="col-12">   
                                        <label class="labelforms"><b>Conteúdo:</b></label>
                                        <x-adminlte-text-editor name="content" v placeholder="Conteúdo do post..." :config="$config">{{ old('content') ?? $post->content }}</x-adminlte-text-editor>                                                      
                                    </div>
                                </div>
                            </div> 
                            
                            <div class="tab-pane fade" id="custom-tabs-imagens" role="tabpanel" aria-labelledby="custom-tabs-imagens-tab">
                                <div class="row mb-4">
                                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">   
                                        <div class="form-group">
                                            <label class="labelforms"><b>Legenda da Imagem de Capa</b></label>
                                            <input type="text" class="form-control"  name="thumb_legenda" value="{{ old('thumb_legenda') ?? $post->thumb_legenda }}">
                                        </div>                                                    
                                    </div>
                                    <div class="col-sm-12">                                        
                                        <div class="form-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" id="exampleInputFile" name="files[]" multiple>
                                                <label class="custom-file-label" for="exampleInputFile">Escolher Arquivos</label>
                                            </div>
                                        </div>
                                        
                                        <div class="content_image"></div> 
                                        
                                        <div class="property_image">
                                            @foreach($post->images()->get() as $image)
                                            <div class="property_image_item">
                                                <a href="{{ $image->url_image }}" data-toggle="lightbox" data-gallery="property-gallery" data-type="image">
                                                    <img src="{{ $image->url_image }}" alt="{{$post->titulo}}">
                                                </a>
                                                <div class="property_image_actions">
                                                    <a href="javascript:void(0)" class="btn btn-xs {{ ($image->cover == true ? 'btn-success' : 'btn-default') }} icon-notext image-set-cover px-2" data-action="{{ route('posts.imageSetCover', ['image' => $image->id]) }}"><i class="nav-icon fas fa-check"></i> </a>
                                                    <a href="javascript:void(0)" class="btn btn-danger btn-xs image-remove px-2" data-action="{{ route('posts.imageRemove', ['image' => $image->id]) }}"><i class="nav-icon fas fa-times"></i> </a>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
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
        @stop

@section('css')
    <!--tags input-->
    <link rel="stylesheet" href="{{url('backend/plugins/jquery-tags-input/jquery.tagsinput.css')}}" />
    <link href="{{url(asset('backend/plugins/airdatepicker/css/datepicker.min.css'))}}" rel="stylesheet" type="text/css">
    <style type="text/css">
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
        /* Lista de ImÃ³veis */
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
<!--tags input-->
<script src="{{url('backend/plugins/jquery-tags-input/jquery.tagsinput.js')}}"></script>
<script src="{{url(asset('backend/plugins/airdatepicker/js/datepicker.min.js'))}}"></script>
<script src="{{url(asset('backend/plugins/airdatepicker/js/i18n/datepicker.pt-BR.js'))}}"></script>    
    <script>
        $(function () {
            
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });     

            

            // Função para chamar as categorias do Post           

            $('.tipo_post').on('change', function (){
                var categoria = this.value;

                $.ajax({
                    url: "{{route('posts.categoriaList')}}",
                    type: "POST",
                    dataType: "json",
                    data: {
                        categoria_tipo: categoria,
                        _token: '{{csrf_token()}}'
                    },
                    beforeSend: function (){
                        $('.categoria').html('Carregando...');
                    },
                    success: function (retorno){
                        //Função da porra                        
                        var fragment="";
                        var modelHTML="";
                        if(retorno.length !== 0){
                            $('.categoria').html('<option value="">Selecione a Categoria</option>');
                            $.each(retorno, function (k, value) {
                                
                                modelHTML +="";
                                $.each(value.subcategory, function (ind, val) { 
                                    var Model_Name = val.titulo;                                   			  
                                    modelHTML += "<option value="+ val.id +">" + val.titulo + "</option>";                                    
                                });
                                
                                fragment +="<optgroup label=" + value.catTitulo + "> "+ modelHTML +" </optgroup>";
                                modelHTML="";
                            });
                            $('.categoria').append(fragment);
                        }else{
                            $('.categoria').html('<option value="">Cadastre uma categoria!</option>');
                        }                       
                    },
                    complete: function (){
                        $('.categoria').attr('disabled', false);
                    }
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