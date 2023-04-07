@extends('web.master.master')


@section('content')
<section class="utf_block_wrapper">
    <div class="container">
        <div class="row">
            @if (!empty($catEmpresas) && $catEmpresas->count() > 0)
                @foreach ($catEmpresas as $key => $catPai)
                    @if ($catPai->countEmpresasPai())
                        <div class="col-lg-4 mb-4">
                            <div class="block color-dark-blue">
                                <h3 class="utf_block_title"><span>{{$catPai->titulo}}</span></h3>  
                                <div class="utf_list_post_block">
                                    @if (!empty($empresas) && $empresas->count() > 0)
                                        <ul class="utf_list_post {{$key}}">
                                            @foreach($empresas as $empresa)    
                                                @if ($empresa->cat_pai == $catPai->id)
                                                    <li class="clearfix" style="min-height: 130px;">
                                                        <div class="utf_post_block_style post-float clearfix">
                                                            <div class="imgbox"> 
                                                                <a href="{{route('web.guiaEmpresa',[ 'slug' => $empresa->slug ])}}"> 
                                                                    <img class="img-fluid" src="{{$empresa->logoCover()}}" alt="{{$empresa->alias_name}}" /> 
                                                                </a> 
                                                            </div>                    
                                                            <div class="utf_post_content">
                                                                <h2 class="utf_post_title title-small" style="margin-bottom: 0px;"> 
                                                                    <a style="color: #B03131 !important;" href="{{route('web.guiaEmpresa',[ 'slug' => $empresa->slug ])}}">{{$empresa->alias_name}}</a> 
                                                                </h2>
                                                                <p>
                                                                    <a class="alink" href="{{route('web.guiaEmpresa',[ 'slug' => $empresa->slug ])}}">
                                                                        {!!Words($empresa->content, 10)!!}
                                                                    </a>
                                                                    <br>
                                                                    <a href="{{route('web.guiaSubCategoria', [ 'slug' => $empresa->categoriaObject->slug ])}}">
                                                                        <b>{{$empresa->categoriaObject->titulo}}</b>
                                                                    </a>
                                                                </p>                                                                
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif                                                                                             
                                            @endforeach                              
                                        </ul>
                                        <a href="{{route('web.guiaCategoria', [ 'slug' => $catPai->slug ])}}" class="ot-widget-button"><b>Ver Tudo</b></a>
                                    @endif                                    
                                </div>
                            </div>
                        </div>
                    @endif                    
                @endforeach                
            @endif 
        </div>
    </div>
</section>
@endsection

@section('css')
    <style>
        .alink{
            color: #333;
        }
        .imgbox{
            float: left;
            position: relative;
            z-index: 1;
            margin-right: 20px;
        }
        .imgbox img{
            max-width: 100px;
            min-height: 75px;
            border-radius: 2px;
            box-shadow: 0 2px 3px rgb(0 0 0 / 10%);
        }
        .ot-widget-button {
            display: block;
            margin-top: 18px;
            text-align: center;
            font-size: 14px;
            background-color: #e4e4e4;
            color: #656565;
            padding: 14px 12px;
            border-radius: 2px;
        }
    </style>
@endsection

@section('js')
    <script>
        $(function () {
            @if (!empty($catEmpresas && $catEmpresas->count() > 0))
                @foreach ($catEmpresas as $key => $catPai)
                    $('.{{$key}} li:gt(4)').remove();
                @endforeach
            @endif
        });        
    </script>
@endsection