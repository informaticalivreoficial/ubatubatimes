@extends('adminlte::page')

@section('title', 'Gerenciar Faturas')

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Faturas</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Faturas</li>
        </ol>
    </div>
</div>
@stop

@section('content')

<section class="content">
    <!-- Default box -->
      <div class="card card-solid">
        <div class="card-header">
            <div class="row">
                <div class="col-12 col-sm-6 my-2">
                    <div class="card-tools">
                        <div style="width: 250px;">
                            <form class="input-group input-group-sm" action="" method="post">
                                @csrf   
                                <input type="text" name="filter" value="" class="form-control float-right" placeholder="Pesquisar">
                
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                      </div>
                </div>
                <div class="col-12 col-sm-6 my-2 text-right">
                    <a href="" class="btn btn-sm btn-default"><i class="fas fa-plus mr-2"></i> Criar Fatura</a>
                </div>
            </div>
        </div>
        <div class="card-body pb-0">
            <div class="row">
                <div class="col-12">                
                    @if(session()->exists('message'))
                        @message(['color' => session()->get('color')])
                            {{ session()->get('message') }}
                        @endmessage
                    @endif
                </div>            
            </div>                        
            
            @if (!empty($faturas) && $faturas->count() > 0)
                <table id="example1" class="table table-bordered table-striped projects">
                    <thead>
                        <tr class="text-muted">
                            <th>#</th>
                            <th>Empresa</th>
                            <th class="text-center">Vencimento</th>
                            <th class="text-center">valor</th>
                            <th class="text-center">Status</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($faturas as $fatura)
                            <tr>
                                <td>{{$fatura->id}}</td>
                                <td>{{$fatura->getEmpresa->alias_name}}</td>
                                <td class="text-center">{{\Carbon\Carbon::parse($fatura->vencimento)->format('d/m/Y')}}</td>
                                <td class="text-center">R$ {{str_replace(',00', '', $fatura->valor)}}</td>
                                <td class="text-center">{!! $fatura->getStatus() !!}</td>
                                <td>
                                    <a href="{{route('faturas.show',['id' => $fatura->id])}}" class="btn btn-xs btn-info text-white"><i class="fas fa-search"></i></a>                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="row mb-4">
                    <div class="col-12">                                                        
                        <div class="alert alert-info p-3">
                            Não foram encontrados registros!
                        </div>                                                        
                    </div>
                </div>
            @endif          
        </div>
        <!-- /.card-body -->
        <div class="card-footer paginacao">  
            @if (isset($filters))
                {{ $faturas->appends($filters)->links() }}
            @else
                {{ $faturas->links() }}
            @endif
        </div>          
      </div>
      <!-- /.card -->
</section>
@stop

@section('plugins.Toastr', true)

@section('css')
<link href="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.css'))}}" rel="stylesheet">
@stop

@section('js')    
    <script src="{{url(asset('backend/plugins/bootstrap-toggle/bootstrap-toggle.min.js'))}}"></script>
    <script>
       $(function () {           
           
           $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            }); 
            
        });
    </script>
@endsection