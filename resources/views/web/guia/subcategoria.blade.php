@extends('web.master.master')

@section('content')

<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li><a href="{{route('web.guiaUbatuba')}}">Guia</a></li>
                    <li><a href="{{route('web.guiaCategoria', [ 'slug' => $subcategoria->father[0]->slug ] )}}">{{$subcategoria->father[0]->titulo}}</a></li>
                    <li>{{$subcategoria->titulo}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>  

<section class="utf_block_wrapper">
    <div class="container">
        <div class="row">
            @if (!empty($subcategoria) && $subcategoria->count() > 0)
            <div class="col-12">
                <div class="block color-dark-blue">
                    <h3 class="utf_block_title"><span>{{$subcategoria->titulo}}</span></h3>
                    @if (!empty($empresas) && $empresas->count() > 0)
                        <div class="row">
                            @foreach ($empresas as $empresa)
                                <div class="col-md-4 mb-4">
                                    <div class="utf_post_block_style post-float clearfix">
                                        <div class="imgbox"> 
                                            <a href="{{route('web.guiaEmpresa',[ 'slug' => $empresa->slug ])}}"> 
                                                <img src="{{$empresa->logoCover()}}" alt="{{$empresa->alias_name}}" /> 
                                            </a> 
                                        </div>                    
                                        <div class="utf_post_content">
                                            <h2 class="utf_post_title title-small" style="margin-bottom: 0px;"> 
                                                <a style="color: #B03131 !important;" href="{{route('web.guiaEmpresa',[ 'slug' => $empresa->slug ])}}">
                                                    {{$empresa->alias_name}}
                                                </a> 
                                            </h2>
                                            <p>
                                                <a class="alink" href="{{route('web.guiaEmpresa',[ 'slug' => $empresa->slug ])}}">
                                                    {!!Words($empresa->content, 16)!!}
                                                </a>                                               
                                                
                                            </p>                                                                
                                        </div>
                                    </div>
                                </div>
                            @endforeach                            
                        </div>
                        <div class="paging">
                            {{$empresas->links()}}                            
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endsection

@section('css')
    <style>
        .pagination-custom{
            margin: 0;
            display: -ms-flexbox;
            display: flex;
            padding-left: 0;
            list-style: none;
            border-radius: 0.25rem;
        }
        .pagination-custom li a {
            border-radius: 30px;
            margin-right: 8px;
            color:#7c7c7c;
            border: 1px solid #ddd;
            position: relative;
            float: left;
            padding: 6px 12px;
            width: 40px;
            height: 40px;
            text-align: center;
            line-height: 25px;
            font-weight: 600;
        }
        .pagination-custom>.active>a, .pagination-custom>.active>a:hover, .pagination-custom>li>a:hover {
            color: #fff;
            background: #ec0000;
            border: 1px solid transparent;
        }
        .imgbox{
            float: left;
            padding-right: 10px;
        }        
        .imgbox img{
            max-width: 120px;
            min-height: 75px;
            border-radius: 2px;
            box-shadow: 0 2px 3px rgb(0 0 0 / 10%);
        }   
        .alink{
            color: #333;
        }     
    </style>
@endsection