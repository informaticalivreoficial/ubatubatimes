@extends('adminlte::page')

@section('title', "Gerenciar Lixeira")

@section('content_header')
<div class="row mb-2">
    <div class="col-sm-6">
        <h1><i class="fas fa-search mr-2"></i> Gerenciar Lixeira</h1>
    </div>
    <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">                    
            <li class="breadcrumb-item"><a href="{{route('home')}}">Painel de Controle</a></li>
            <li class="breadcrumb-item active">Gerenciar Lixeira</li>
        </ol>
    </div>
</div>
@stop

@section('content')
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <div class="row">
                <div class="col-12">                
                    @if(session()->exists('message'))
                        @message(['color' => session()->get('color')])
                            {{ session()->get('message') }}
                        @endmessage
                    @endif
                </div>            
            </div>
            @if(!empty($posts) && $posts->count() > 0)
                <table id="example1" class="table table-bordered table-striped projects">
                    <thead>
                        <tr>
                            <th>Capa</th>
                            <th>Título</th>
                            <th>Categoria</th>
                            <th class="text-center">Views</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody> 
                        @foreach($posts as $post)                        
                        <tr style="{{ ($post->status == '1' ? '' : 'background: #fffed8 !important;')  }}">                            
                            <td class="text-center">
                                <a href="{{ $post->nocover() }}" data-title="{{$post->titulo}}" data-toggle="lightbox">
                                    <img width="60" alt="{{$post->titulo}}" src="{{$post->cover()}}">
                                </a>
                            </td>
                            <td>{{$post->titulo}}</td>
                            <td>{{$post->categoriaObject->titulo}}</td>
                            <td class="text-center">{{$post->views}}</td>
                            <td>
                                <button type="button" class="btn btn-xs btn-danger text-white j_modal_btn" data-id="{{$post->id}}" data-toggle="modal" data-target="#modal-default"><i class="fas fa-trash"></i></button>
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
        <div class="card-footer paginacao">  
            {{ $posts->links() }}
        </div>
    </div>
    <!-- /.card -->   
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="frm" action="" method="post">            
            @csrf
            @method('DELETE')
            <input id="id_post" name="post_id" type="hidden" value=""/>
                <div class="modal-header">
                    <h4 class="modal-title">Remover Post!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <span class="j_param_data"></span>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Sair</button>
                    <button type="submit" class="btn btn-primary">Excluir Agora</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
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
            background: #007bff;
            border: 1px solid transparent;
        }
</style>
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
            
            //FUNÇÃO PARA EXCLUIR
            $('.j_modal_btn').click(function() {
                var post_id = $(this).data('id');
                
                $.ajax({
                    type: 'GET',
                    dataType: 'JSON',
                    url: "{{ route('posts.delete') }}",
                    data: {
                       'id': post_id
                    },
                    success:function(data) {
                        if(data.error){
                            $('.j_param_data').html(data.error);
                            $('#id_post').val(data.id);
                            $('#frm').prop('action','{{ route('posts.deleteon') }}');
                        }else{
                            $('#frm').prop('action','{{ route('posts.deleteon') }}');
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