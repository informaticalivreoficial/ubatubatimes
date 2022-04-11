@extends('web.master.master')

@section('content')

<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li>{{($post->tipo == 'noticia' ? 'Notícia' : 'Blog - Artigo')}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<section class="utf_block_wrapper">
  <div class="container">
    <div class="row">
      <div class="col-lg-8 col-md-12">
        <div class="single-post">
            <div class="utf_post_title-area"> <a class="utf_post_cat" href="#">{{$post->categoriaObject->titulo}}</a>
                <h2 class="utf_post_title">{{$post->titulo}}</h2>
                <div class="utf_post_meta"> 
                    <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</span> 
                    <span class="post-hits"><i class="fa fa-eye"></i> {{$post->views}}</span> 
                    {{--<span class="post-comment"><i class="fa fa-comments-o"></i> <a href="#" class="comments-link"><span>01</span></a></span> --}}
                    <div class="fb-share-button" data-href="{{url()->current()}}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartilhar</a></div>
                    <a class="btn-front" target="_blank" href="https://web.whatsapp.com/send?text={{url()->current()}}" data-action="share/whatsapp/share"><i class="fa fa-whatsapp"></i> Compartilhar</a>
                </div>                
            </div>

            <div class="utf_post_content-area">
                <div class="post-media post-featured-image"> 
                    <a href="{{$post->nocover()}}" class="gallery-popup">
                        <img src="{{$post->cover()}}" class="img-fluid" alt="{{$post->titulo}}">
                    </a> 
                </div>
                <div class="entry-content">
                    {!!$post->content!!}

                    @if($post->images()->get()->count()) 
                        <div class="row mt-3">                   
                            @foreach($post->images()->get() as $image)                                
                                <div class="col-4">
                                  <div class="utf_post_thumb">                            
                                      <a href="{{ $image->url_image }}" class="gallery-popup">
                                          <img class="img-fluid" src="{{ $image->url_image }}" alt="{{ $post->titulo }}"> 
                                      </a>                            
                                  </div>
                                </div>                                                        
                            @endforeach 
                        </div>                               
                    @endif
                </div>
              
                <div class="share-items clearfix">
                    <h5>Compartilhe este artigo:</h5>
                    <div class="fb-share-button" data-href="{{url()->current()}}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartilhar</a></div>
                    <a class="btn-front" target="_blank" href="https://web.whatsapp.com/send?text={{url()->current()}}" data-action="share/whatsapp/share"><i class="fa fa-whatsapp"></i> Compartilhar</a>
                </div>              
            </div>
        </div>
        
        <nav class="post-navigation clearfix">
            @if (!empty($postprevious) && $postprevious->count() > 0)
                <div class="post-previous"> 
                    <a href="{{route(($postprevious->tipo == 'artigo' ? 'web.blog.artigo' : 'web.noticia'), ['slug' => $postprevious->slug] )}}"> <span><i class="fa fa-angle-left"></i>Anterior</span>
                        <h3>{{$postprevious->titulo}}</h3>
                    </a> 
                </div>
            @endif
            @if (!empty($postnext) && $postnext->count() > 0)
                <div class="post-next"> 
                    <a href="{{route(($postnext->tipo == 'artigo' ? 'web.blog.artigo' : 'web.noticia'), ['slug' => $postnext->slug] )}}"> <span>Próximo <i class="fa fa-angle-right"></i></span>
                        <h3>{{$postnext->titulo}}</h3>
                    </a> 
                </div>
            @endif
        </nav>
        
        @if ($post->tipo == 'artigo')
            <div class="author-box">
                <div class="author-img pull-left"> 
                    <img src="images/news/author.png" alt=""> 
                </div>
                <div class="author-info">
                    <h3>Miss Lisa Doe</h3>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since It has survived not only five centuries, but also the leap into electronic type setting, remaining essentially unchanged.</p>              
                </div>
            </div>
        @endif
        
        <!-- Post comment start 
        <div id="comments" class="comments-area block">
          <h3 class="utf_block_title"><span>03 Comments</span></h3>
          <ul class="comments-list">
            <li>
              <div class="comment"> <img class="comment-avatar pull-left" alt="" src="images/news/user1.png">
                <div class="comment-body">
                  <div class="meta-data"> <span class="comment-author">Miss Lisa Doe</span> <span class="comment-date pull-right">15 Jan, 2021</span> </div>
                  <div class="comment-content">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since It has survived not only five centuries, but also the leap into electronic type setting, remaining essentially unchanged.</p>
                  </div>
                  <div class="text-left"> <a class="comment-reply" href="#"><i class="fa fa-share"></i> Reply</a> </div>
                </div>
              </div>
              
              <ul class="comments-reply">
                <li>
                  <div class="comment"> <img class="comment-avatar pull-left" alt="" src="images/news/user2.png">
                    <div class="comment-body">
                      <div class="meta-data"> <span class="comment-author">Miss Lisa Doe</span> <span class="comment-date pull-right">15 Jan, 2021</span> </div>
          <div class="comment-content">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since It has survived not only five centuries, but also the leap into electronic type setting, remaining essentially unchanged.</p>
          </div>
          <div class="text-left"> <a class="comment-reply" href="#"><i class="fa fa-share"></i> Reply</a> </div>
                    </div>
                  </div>
                </li>
              </ul>
              <div class="comment last"> <img class="comment-avatar pull-left" alt="" src="images/news/user1.png">
                <div class="comment-body">
                  <div class="meta-data"> <span class="comment-author">Miss Lisa Doe</span> <span class="comment-date pull-right">15 Jan, 2021</span> </div>
                  <div class="comment-content">
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since It has survived not only five centuries, but also the leap into electronic type setting, remaining essentially unchanged.</p>
                  </div>
                  <div class="text-left"> <a class="comment-reply" href="#"><i class="fa fa-share"></i> Reply</a> </div>
                </div>
              </div>
            </li>
          </ul>
        </div>
         Post comment end -->
        
    <!-- Comments Form Start 
        <div class="comments-form">
          <h3 class="title-normal">Leave a comment</h3>
          <form>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" name="name" id="name" placeholder="Name" type="text" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" name="email" id="email" placeholder="Email" type="email" required>
                </div>
              </div>
      <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" placeholder="Phone" type="text" required>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <input class="form-control" placeholder="Subject" type="text" required>
                </div>
              </div>
      <div class="col-md-12">
                <div class="form-group">
                  <textarea class="form-control required-field" id="message" placeholder="Comment" rows="10" required></textarea>
                </div>
              </div>
            </div>
            <div class="clearfix">
              <button class="comments-btn btn btn-primary" type="submit">Post Comment</button>
            </div>
          </form>
        </div>
         Comments form end -->           
      </div>
      
      <div class="col-lg-4 col-md-12">
          <div class="sidebar utf_sidebar_right">  
            
              <div class="widget text-center" style="background-color: #efefef; padding: 30px 0;"> 
                <img class="banner img-fluid" src="{{url(asset('frontend/assets/images/tim.png'))}}" alt="" /> 
              </div>

              <div class="widget text-center" style="background-color: #efefef; padding: 30px 0;"> 
                <img class="banner img-fluid" src="{{url(asset('frontend/assets/images/anjosads.png'))}}" alt="" /> 
              </div>

              @if (!empty($postsMais) && $postsMais->count() > 0)
                  <div class="widget color-default">
                      <h3 class="utf_block_title"><span>Veja Também</span></h3>
                      <div class="utf_list_post_block">
                          <ul class="utf_list_post">
                              @foreach ($postsMais as $postmais)
                                <li class="clearfix" style="min-height: 130px;">
                                    <div class="utf_post_block_style post-float clearfix">
                                        <div class="utf_post_thumb"> 
                                            <a href="{{route(($postmais->tipo == 'artigo' ? 'web.blog.artigo' : 'web.noticia'), ['slug' => $postmais->slug] )}}"> 
                                                <img class="img-fluid" src="{{$postmais->cover()}}" alt="{{$postmais->titulo}}" /> 
                                            </a> 
                                        </div>                      
                                        <div class="utf_post_content">
                                            <h2 class="utf_post_title title-small"> 
                                                <a href="{{route(($postmais->tipo == 'artigo' ? 'web.blog.artigo' : 'web.noticia'), ['slug' => $postmais->slug] )}}">{{$postmais->titulo}}</a> 
                                            </h2>
                                            <div class="utf_post_meta"> 
                                                <span class="utf_post_author"><i class="fa fa-eye"></i> {{$postmais->views}}</span> 
                                                <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($postmais->created_at)->format('d/m/Y') }}</span> 
                                            </div>
                                        </div>
                                    </div>
                                </li>
                              @endforeach
                          </ul>
                      </div>
                  </div>
              @endif   
            
              @if (!empty($categorias) && $categorias->count() > 0)
                <div class="widget widget-categories">
                    <h3 class="utf_block_title"><span>Categorias</span></h3>
                    <ul class="list-round mr_bottom-20">
                        @foreach ($categorias as $categoria)
                            @if ($categoria->countposts() >= 1)
                                <li>
                                    <a href="{{route(($categoria->tipo == 'artigo' ? 'web.blog.categoria' : 'web.noticia.categoria'), ['slug' => $categoria->slug] )}}">
                                        <span class="catTitle"> {{$categoria->titulo}}</span><span class="catCounter"> ({{$categoria->countposts()}})</span>
                                    </a> 
                                </li>
                            @endif                        
                        @endforeach                                            
                    </ul>
                </div>
              @endif
              
              @if(!empty($postsTags) && $postsTags->count() > 0)  
                  <div class="widget widget-tags">
                      <h3 class="utf_block_title"><span>Popular Tags</span></h3>
                      <ul class="unstyled clearfix">
                        @foreach($postsTags as $posttags) 
                            @php
                                $array = explode(",", $posttags->tags);
                                foreach($array as $tags){
                                    $tag = trim($tags);                                                       
                                    echo '<li>';
                                    if($posttags->tipo == 'artigo'){
                                        echo '<a href="'.route('web.blog.artigo',['slug' => $posttags->slug]).'">';
                                    }else{
                                        echo '<a href="'.route('web.noticia',['slug' => $posttags->slug]).'">';
                                    }    
                                    echo $tag;
                                    echo '</a></li>';
                                }
                            @endphp                                                     
                        @endforeach              
                      </ul>
                  </div>
              @endif


              <div class="widget">
                  <div class="utf_newsletter_block">
                      <div class="utf_newsletter_introtext">
                          <h4>Subscribe Newsletter!</h4>
                          <p>Lorem ipsum dolor sit consectetur adipiscing elit Maecenas in pulvinar neque Nulla finibus lobortis pulvinar.</p>
                      </div>
                      <div class="utf_newsletter_form">
                          <form action="#" method="post">
                              <div class="form-group">
                                  <input type="email" name="email" id="utf_newsletter_form-email" class="form-control form-control-lg" placeholder="E-Mail Address" autocomplete="off">
                                  <button class="btn btn-primary">Subscribe</button>
                              </div>
                          </form>
                      </div>
                  </div>
              </div> 
              
              <div class="widget text-center">
                  <div class="fb-root fb-widget">
                      <div class="fb-page-responsive">
                          <div data-href="{{$configuracoes->facebook}}" data-tabs="timeline" data-height="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" class="fb-page">
                              <div class="fb-xfbml-parse-ignore">
                                <blockquote cite="{{$configuracoes->facebook}}"><a href="{{$configuracoes->facebook}}">{{$configuracoes->nomedosite}}</a></blockquote>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>


          </div>
      </div>        
    </div>
  </div>
</section>
  
@endsection

@section('css')
<style>
    .btn-front{
        background-color: #6ebf58;
        color:#fff;
        border-radius: .25rem;
        padding: 5px 8px !important;
        border:none;
    }
    .btn-front:hover, mdi:hover{
        color:#fff;
    }
</style>
@endsection

@section('js')
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v11.0&appId=1787040554899561&autoLogAppEvents=1" nonce="1eBNUT9J"></script>
@endsection