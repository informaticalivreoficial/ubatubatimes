@extends('web.master.master')


@section('content')
<section class="utf_block_wrapper">
    <div class="container">
        <div class="row">
            @if (!empty($catEmpresas && $catEmpresas->count() > 0))
                @foreach ($catEmpresas as $catPai)
                    @if ($catPai->countEmpresasPai())
                        <div class="col-lg-4">
                            <div class="block color-dark-blue">
                                <h3 class="utf_block_title"><span>{{$catPai->titulo}}</span></h3>  
                                <div class="utf_list_post_block">
                                    @if (!empty($empresas) && $empresas->count() > 0)
                                        <ul class="utf_list_post">
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
                                                                    {!!Words($empresa->content, 10)!!}
                                                                    <br><b>{{$empresa->categoriaObject->titulo}}</b>
                                                                </p>                                                                
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endif                                                                                             
                                            @endforeach                              
                                        </ul>
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
    </style>
@endsection