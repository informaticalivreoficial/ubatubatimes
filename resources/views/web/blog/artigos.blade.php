@extends('web.master.master')

@section('content')

<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li>{{(!empty($posts) && $posts[0]->tipo == 'noticia' ? 'Notícias' : 'Blog')}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@if(!empty($posts) && $posts->count() > 0)
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
                                            <a href="{{route(($post->tipo == 'noticia' ? 'web.noticia' : 'web.blog.artigo'), [ 'slug' => $post->slug ])}}"> 
                                                <img class="img_person" src="{{$post->cover()}}" alt="{{$post->titulo}}" /> 
                                            </a> 
                                        </div>
                                        <a class="utf_post_cat" href="{{route('web.blog.categoria', [ 'slug' => $post->categoriaObject->slug ])}}">{{$post->categoriaObject->titulo}}</a>
                                        <div class="utf_post_content">
                                            <h2 class="utf_post_title title-large"> <a href="{{route(($post->tipo == 'noticia' ? 'web.noticia' : 'web.blog.artigo'), [ 'slug' => $post->slug ])}}">{{$post->titulo}}</a> </h2>
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

        @if (!empty($positionFooterBlog) && $positionFooterBlog->count() > 0)
            @foreach($positionFooterBlog as $f)
                <div class="utf_ad_content_area text-center utf_banner_area">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12"> 
                                <a href="{{$f->link ?? '#'}}" target="_blank">
                                    <img class="img-fluid" src="{{$f->get728x90()}}" alt="{{$f->titulo}}" /> 
                                </a>
                            </div>
                        </div>
                    </div>
                </div>                    
            @endforeach
        @else
            <div class="utf_ad_content_area text-center utf_banner_area">  
                <div class="container">
                    <div class="row">
                        <div class="col-md-12"> 
                            <a href="{{route('web.anunciar')}}" target="_blank">
                                <img class="img-fluid" src="{{url(asset('backend/assets/images/banner728x90.jpg'))}}" alt="Anuncie Aqui!" /> 
                            </a> 
                        </div>
                    </div>
                </div>                                                               
            </div>        
        @endif        
    </section>
@endif

@endsection

@section('css')
    <style>
        .img_person{
            min-height: 250px !important;
            max-height: 250px !important;
        }
    </style>
@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
<script>
    // Paginação infinita
    $('ul.pagination').hide();
    $(function() {
        $('.scrolling-pagination').jscroll({
            autoTrigger: true,
            padding: 0,
            nextSelector: '.pagination li.active + li a',
            contentSelector: 'div.scrolling-pagination',
            callback: function() {
                $('ul.pagination').remove();
            }
        });
    });       
</script>
@endsection