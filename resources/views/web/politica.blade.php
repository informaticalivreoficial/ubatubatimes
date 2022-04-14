@extends('web.master.master')

@section('content')
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li>Política de Privacidade</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="utf_block_wrapper">
    <div class="container">
        <div class="col-12">            
            <div class="row justify-content-md-center">
                <div class="col-12" style="color: #0c0707;">
                    {!! $configuracoes->politicas_de_privacidade !!}
                </div>
            </div>
        </div>
    </div>
  </section>
@endsection