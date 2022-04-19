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
                                <div class="row mb-2">
                                    <div class="col-12 col-md-4 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Responsável Legal:</b></label>
                                            <input type="text" class="form-control" name="responsavel" value="{{ old('responsavel') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Responsável Email:</b></label>
                                            <input type="text" class="form-control" name="responsavel_email" value="{{ old('responsavel_email') }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-4 col-lg-4"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>CPF</b></label>
                                            <input type="text" class="form-control cpfmask" name="cpf" value="{{ old('cpf') }}"/>
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
                                        <input id="img-input" type="file" name="logomarca">
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
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Estado:</b></label>
                                    <select id="state-dd" class="form-control" name="uf">
                                        @if(!empty($estados))
                                            <option value="">Selecione o Estado</option>
                                            @foreach($estados as $estado)
                                            <option value="{{$estado->estado_id}}" {{ (old('uf') == $estado->estado_id ? 'selected' : '') }}>{{$estado->estado_nome}}</option>
                                            @endforeach                                                                        
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Cidade:</b></label>
                                    <select id="city-dd" class="form-control" name="cidade">
                                        @if(!empty($cidades)))
                                            <option value="">Selecione o Estado</option>
                                            @foreach($cidades as $cidade)
                                                <option value="{{$cidade->cidade_id}}" 
                                                        {{ (old('cidade') == $cidade->cidade_id ? 'selected' : '') }}>{{$cidade->cidade_nome}}</option>                                                                   
                                            @endforeach                                                                        
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-4 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Bairro:</b></label>
                                    <input type="text" class="form-control" name="bairro" value="{{old('bairro')}}">
                                </div>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12 col-md-6 col-lg-5"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Endereço:</b></label>
                                    <input type="text" class="form-control" name="rua" value="{{old('rua')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Número:</b></label>
                                    <input type="text" class="form-control" name="num" value="{{old('num')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-3"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Complemento:</b></label>
                                    <input type="text" class="form-control" name="complemento" value="{{old('complemento')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-2"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>CEP:</b></label>
                                    <input type="text" class="form-control mask-zipcode" name="cep" value="{{old('cep')}}">
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
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>Sound Cloud:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="Linkedin" name="soundclound" value="{{old('soundclound')}}">
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <label class="labelforms text-muted"><b>SnapChat:</b></label>
                                    <input type="text" class="form-control text-muted" placeholder="SnapChat" name="snapchat" value="{{old('snapchat')}}">
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
                                        <input id="img-input" type="file" name="metaimg">
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
        document.getElementById("img-input").addEventListener("change", readImageMetaImagem, false);
        document.getElementById("img-input").addEventListener("change", readImage, false);

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

    });
</script>
@endsection