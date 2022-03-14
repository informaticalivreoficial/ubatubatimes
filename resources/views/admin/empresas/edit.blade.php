@extends('adminlte::page')

@section('title', 'Editar Empresa')

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
                        <a class="nav-link" id="custom-tabs-four-redes-tab" data-toggle="pill" href="#custom-tabs-four-redes" role="tab" aria-controls="custom-tabs-four-redes" aria-selected="false">Redes Sociais</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-four-pedidos-tab" data-toggle="pill" href="#custom-tabs-four-pedidos" role="tab" aria-controls="custom-tabs-four-pedidos" aria-selected="false">Pedidos</a>
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
                            <div class="col-12 col-md-6 col-lg-4"> 
                                <div class="form-group">
                                    <div class="thumb_user_admin">
                                        @php
                                            if(!empty($empresa->logomarca) && \Illuminate\Support\Facades\File::exists(public_path() . '/storage/' . $empresa->logomarca)){
                                                $cover = $empresa->cover();
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
                                            <label class="labelforms text-muted"><b>*Responsável Legal:</b></label>
                                            <select class="form-control" name="user">
                                                <option value="" selected>Selecione um responsável legal</option> 
                                                @foreach($users as $user)                                                    
                                                    <option value="{{ $user->id }}" {{ ($user->id == $empresa->user ? 'selected' : '') }}>{{ $user->name }} ({{ $user->cpf }})</option>                                                   
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>*Razão Social:</b></label>
                                            <input type="text" class="form-control" placeholder="Razão Social" name="social_name" value="{{ old('social_name') ?? $empresa->social_name }}">
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6 col-lg-6"> 
                                        <div class="form-group">
                                            <label class="labelforms text-muted"><b>Nome Fantasia:</b></label>
                                            <input type="text" class="form-control" placeholder="Nome Fantasia" name="alias_name" value="{{ old('alias_name') ?? $empresa->alias_name }}">
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
                                </div>
                            </div>
                            
                        </div>
                        
                        <div id="accordion">
                            <!-- we are adding the .class so bootstrap.js collapse plugin detects it -->
                            <div class="card">
                                <div class="card-header">
                                    <h4>
                                        <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseEndereco">
                                            <i class="nav-icon fas fa-plus mr-2"></i> Endereço
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseEndereco" class="panel-collapse collapse show">
                                    <div class="card-body">
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
                                                    <input type="text" class="form-control" placeholder="Endereço Completo" name="rua" value="{{old('rua') ?? $empresa->rua}}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-2"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>*Número:</b></label>
                                                    <input type="text" class="form-control" placeholder="Número do Endereço" name="num" value="{{old('num') ?? $empresa->num}}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>Complemento:</b></label>
                                                    <input type="text" class="form-control" placeholder="Complemento (Opcional)" name="complemento" value="{{old('complemento') ?? $empresa->complemento}}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-2"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>*CEP:</b></label>
                                                    <input type="text" class="form-control mask-zipcode" placeholder="Digite o CEP" name="cep" value="{{old('cep') ?? $empresa->cep}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    <h4>
                                        <a style="border:none;color: #555;" data-toggle="collapse" data-parent="#accordion" href="#collapseContato">
                                            <i class="nav-icon fas fa-plus mr-2"></i> Contato
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapseContato" class="panel-collapse collapse show">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-12 col-md-6 col-lg-4"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>Email:</b></label>
                                                    <input type="text" class="form-control" placeholder="Email" name="email" value="{{old('email') ?? $empresa->email}}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>Telefone Fixo:</b></label>
                                                    <input type="text" class="form-control telefonemask" placeholder="Número do Telefone com DDD" name="telefone" value="{{old('telefone') ?? $empresa->telefone}}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-3"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>*Celular:</b></label>
                                                    <input type="text" class="form-control celularmask" placeholder="Número do Celular com DDD" name="celular" value="{{old('celular') ?? $empresa->celular}}">
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-6 col-lg-2"> 
                                                <div class="form-group">
                                                    <label class="labelforms text-muted"><b>WhatsApp:</b></label>
                                                    <input type="text" class="form-control whatsappmask" placeholder="Número do Celular com DDD" name="whatsapp" value="{{old('whatsapp') ?? $empresa->whatsapp}}">
                                                </div>
                                            </div>                                                    
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">   
                                    <label class="labelforms text-muted"><b>Informações Adicionais</b></label>
                                    <textarea id="inputDescription" class="form-control" rows="5" name="notasadicionais">{{ old('notasadicionais') ?? $empresa->notasadicionais }}</textarea>                                                      
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
    <style>
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
                        
        }
    </style>
@stop

@section('js')
<script src="{{url(asset('backend/assets/js/jquery.mask.js'))}}"></script>
<script>
    $(document).ready(function () { 
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

    });
</script>
@endsection