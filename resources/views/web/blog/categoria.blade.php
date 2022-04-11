@extends('web.master.master')

@section('content')
<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li>{{$type}} - {{$categoria->titulo}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@if($posts->count() && $posts->count() > 0)
    <section class="utf_block_wrapper">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12">
                    <div class="block category-listing scrolling-pagination">
                        <div class="row">
                            @foreach($posts as $post)
                                <div class="col-lg-4">
                                    <div class="utf_post_block_style post-grid clearfix">
                                        <div class="utf_post_thumb"> 
                                            <a href="{{route(($post->tipo == 'artigo' ? 'web.blog.artigo' : 'web.noticia'),[ 'slug' => $post->slug ])}}"> 
                                                <img class="img-fluid" src="{{$post->cover()}}" alt="" /> 
                                            </a> 
                                        </div>
                                        <a class="utf_post_cat" href="{{route('web.blog.categoria', [ 'slug' => $post->categoriaObject->slug ])}}">{{$post->categoriaObject->titulo}}</a>
                                        <div class="utf_post_content">
                                            <h2 class="utf_post_title title-large"> 
                                                <a href="{{route(($post->tipo == 'artigo' ? 'web.blog.artigo' : 'web.noticia'),['slug' => $post->slug])}}">{{$post->titulo}}</a> 
                                            </h2>
                                            <div class="utf_post_meta"> 
                                                <span class="utf_post_author"><i class="fa fa-eye"></i> {{$post->views}}</span> 
                                                <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</span> 
                                                {{--<span class="post-comment pull-right"><i class="fa fa-comments-o"></i> <a href="#" class="comments-link"><span>03</span></a></span> --}}
                                            </div>					
                                            <p>{!! Words($post->content, 21) !!}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if (isset($filters))
                                {{ $posts->appends($filters)->links() }}
                            @else
                                {{ $posts->links() }}
                            @endif
                        </div>                        
                    </div>                              
                </div>  
            </div>
        </div>
    </section>
@endif

@endsection

@section('css')

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script>
    // Paginação infinita
    $('ul.pagination-custom').hide();
    $(function() {
        $('.scrolling-pagination').jscroll({
            autoTrigger: true,
            padding: 0,
            nextSelector: '.pagination-custom li.active + li a',
            contentSelector: 'div.scrolling-pagination',
            callback: function() {
                $('ul.pagination-custom').remove();
            }
        });
    });       
</script>
@endsection