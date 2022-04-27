@extends('web.master.master')

@section('content')

<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li><a href="{{route('web.pesquisa')}}">Pesquisa no site</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <form action="{{ route('web.pesquisa') }}" method="post">
                    @csrf
                    <div class="input-group input-group-lg mb-2">                        
                        <input class="form-control" type="text" name="search" value="{{$search ?? ''}}">
                    </div>
                    <button class="btn btn-block btn-primary" type="submit">Pesquisar</button>
                </form>
            </div>            
        </div>
    </div>
</section>

<section class="section">
    <div class="container">        
        @if ($search && !empty($data) && count($data) > 0)
            @foreach ($data as $item)
                <div class="row">                    
                    <div class="col-12">
                        <h5>{{$item['tipo']}}: <a class="linksearch" href="{{$item['link']}}">{{$item['titulo']}}</a></h5>
                        <p>
                        {!! Words($item['desc'], 30) !!}
                        </p>
                    </div>
                </div>
            @endforeach
            <div class="paging">
                {{$data->links()}}                            
            </div>
        @endif        
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
    .linksearch{
        color: #2083f4;
    }
    .linksearch:hover{
        color: #F48920;
        text-decoration: underline;
    }
</style>
@endsection