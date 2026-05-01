@extends('web.master.master')

@section('content')

<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li>{{($post->type == 'noticia' ? 'Notícia' : 'Blog')}}</li>
                    <li>{{$post->title}}</li>
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
            <div class="utf_post_title-area"> <a class="utf_post_cat" href="{{route('web.blog.categoria', [ 'slug' => $post->categoryObject->slug ])}}">{{$post->categoryObject->title}}</a>
                <h2 class="utf_post_title">{{$post->title}}</h2>
                <div class="utf_post_meta mb-2"> 
                    <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</span> 
                    <span class="post-hits"><i class="fa fa-eye"></i> {{$post->views}}</span> 
                    {{--<span class="post-comment"><i class="fa fa-comments-o"></i> <a href="#" class="comments-link"><span>01</span></a></span> --}}
                    
                </div>  
                <div class="fb-share-button" data-href="{{url()->current()}}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartilhar</a></div>
                <a class="btn-front" target="_blank" href="https://web.whatsapp.com/send?text={{url()->current()}}" data-action="share/whatsapp/share"><i class="fa fa-whatsapp"></i> Compartilhar</a>              
            </div>

            <div class="utf_post_content-area">
                <div class="post-media post-featured-image"> 
                    <a href="{{$post->nocover()}}" class="gallery-popup">
                        <img src="{{$post->cover()}}" class="img-fluid" alt="{{$post->title}}">
                    </a> 
                </div>
                <div class="entry-content">
                    {!!$post->content!!}
                    <p>{{$post->thumb_legenda}}</p>
                    @if($post->images()->get()->count()) 
                        <div class="row mt-3">                   
                            @foreach($post->images()->get() as $image)                                
                                <div class="col-4 mb-3">
                                  <div class="utf_post_thumb">                            
                                      <a href="{{ $image->url_image }}" class="gallery-popup">
                                          <img class="img-fluid" src="{{ $image->url_cropped }}" alt="{{ $post->title }}"> 
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
                    <a href="{{route(($postprevious->type == 'artigo' ? 'web.blog.artigo' : 'web.noticia'), ['slug' => $postprevious->slug] )}}"> <span><i class="fa fa-angle-left"></i>Anterior</span>
                        <h3>{{$postprevious->title}}</h3>
                    </a> 
                </div>
            @endif
            @if (!empty($postnext) && $postnext->count() > 0)
                <div class="post-next"> 
                    <a href="{{route(($postnext->type == 'artigo' ? 'web.blog.artigo' : 'web.noticia'), ['slug' => $postnext->slug] )}}"> <span>Próximo <i class="fa fa-angle-right"></i></span>
                        <h3>{{$postnext->title}}</h3>
                    </a> 
                </div>
            @endif
        </nav>
        
        @if ($post->type == 'artigo')
            <div class="author-box">
                <div class="author-img pull-left"> 
                    <img src="{{$post->user->getUrlAvatarAttribute()}}" alt="{{$post->user->name}}"> 
                </div>
                <div class="author-info">
                    <h3>{{$post->user->name}}</h3>
                    <p>
                        {!!$post->user->notasadicionais!!}
                        <ul class="unstyled utf_footer_social">
                            @if ($post->user->facebook)
                                <li><a target="_blank" href="{{$post->user->facebook}}" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                            @endif
                            @if ($post->user->twitter)
                                <li><a target="_blank" href="{{$post->user->twitter}}" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                            @endif
                            @if ($post->user->instagram)
                                <li><a target="_blank" href="{{$post->user->instagram}}" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                            @endif
                            @if ($post->user->linkedin)
                                <li><a target="_blank" href="{{$post->user->linkedin}}" title="linkedin"><i class="fa fa-linkedin"></i></a></li>
                            @endif
                        </ul>
                    </p>     
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
            
                @if (!empty($positionSidebarPost) && $positionSidebarPost->count() > 0)
                    @foreach($positionSidebarPost as $p)
                        <div class="widget text-center">                                    
                            <a href="{{$p->link ?? '#'}}" target="_blank">
                                <img class="banner img-fluid" src="{{$p->get300x250()}}" alt="{{$p->title}}" />
                            </a>                                                                      
                        </div>
                    @endforeach
                @else
                    <div class="widget text-center">                                    
                        <x-ad slot="article_sidebar" />                                                                      
                    </div>
                    <div class="widget text-center">                                    
                        <x-ad slot="article_sidebar_1" />                                                                      
                    </div>
                @endif

                @if (!empty($postsMais) && $postsMais->count() > 0)
                    <div class="widget color-default">
                        <h3 class="utf_block_title"><span>Veja Também</span></h3>
                        <div class="utf_list_post_block">
                            <ul class="utf_list_post">
                                @foreach ($postsMais as $postmais)
                                    <li class="clearfix" style="min-height: 130px;">
                                        <div class="utf_post_block_style post-float clearfix">
                                            <div class="utf_post_thumb"> 
                                                <a href="{{route(($postmais->type == 'artigo' ? 'web.blog.artigo' : 'web.noticia'), ['slug' => $postmais->slug] )}}"> 
                                                    <img class="img_person" src="{{$postmais->cover()}}" alt="{{$postmais->title}}" /> 
                                                </a> 
                                            </div>                      
                                            <div class="utf_post_content">
                                                <h2 class="utf_post_title title-small"> 
                                                    <a href="{{route(($postmais->type == 'artigo' ? 'web.blog.artigo' : 'web.noticia'), ['slug' => $postmais->slug] )}}">{{$postmais->title}}</a> 
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
                            @if ($categoria->posts->count() >= 1)
                                <li>
                                    <a href="{{route(($categoria->type == 'artigo' ? 'web.blog.categoria' : 'web.noticia.categoria'), ['slug' => $categoria->slug] )}}">
                                        <span class="catTitle"> {{$categoria->title}}</span><span class="catCounter"> ({{$categoria->posts->count()}})</span>
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
                                    if($posttags->type == 'artigo'){
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

              {{--  
              @if ($newsletterForm)
                  <div class="widget">
                      <div class="utf_newsletter_block">
                          <div class="utf_newsletter_introtext">
                              <h4>Newsletter</h4>
                              <p>Receba direto no seu e-mail, nossas dicas e notícias sempre atualizadas!</p>
                          </div>
                          <div class="utf_newsletter_form">
                              <form class="j_submitnewsletter" action="" method="POST">
                                  @csrf                                
                                  <div id="js-newsletter-result"></div>
                                  <div class="form-group form_hide">
                                      <!-- HONEYPOT -->
                                      <input type="hidden" class="noclear" name="bairro" value="" />
                                      <input type="text" class="noclear" style="display: none;" name="cidade" value="" />
                                      <input type="hidden" class="noclear" name="status" value="1" />
                                      <input type="hidden" class="noclear" name="nome" value="#Cadastrado pelo Site" />
                                      <input type="email" name="email" id="utf_newsletter_form-email" class="form-control form-control-lg" placeholder="Seu email..." autocomplete="off">
                                      <button type="submit" class="btn btn-primary" id="js-subscribe-btn">Inscrever</button>
                                  </div>
                              </form>
                          </div>
                      </div>
                  </div>
              @endif 
              --}}

              <div class="widget text-center">
                  <div class="fb-root fb-widget">
                      <div class="fb-page-responsive">
                          <div data-href="{{$config->facebook}}" data-tabs="timeline" data-height="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" class="fb-page">
                              <div class="fb-xfbml-parse-ignore">
                                <blockquote cite="{{$config->facebook}}"><a href="{{$config->facebook}}">{{$config->nomedosite}}</a></blockquote>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>     
         
    </div>
  </div>

    @if (!empty($positionFooterPost) && $positionFooterPost->count() > 0)
        @foreach($positionFooterPost as $f)
            <div class="utf_ad_content_area text-center utf_banner_area">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12"> 
                            <a href="{{$f->link ?? '#'}}" target="_blank">
                                <img class="img-fluid" src="{{$f->get728x90()}}" alt="{{$f->title}}" /> 
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
                        <x-ad slot="article_footer" /> 
                    </div>
                </div>
            </div>                                                               
        </div>        
    @endif

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
    .img_person{
        min-height: 75px !important;
        max-height: 75px !important;
        min-width: 100px !important;
    }
    .utf_footer_social li {
        margin: 0;
        margin-top: 10px;
        display: inline-block;
    }
</style>
@endsection

@section('js')

<script>
  
</script>

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v11.0&appId=1787040554899561&autoLogAppEvents=1" nonce="1eBNUT9J"></script>
@endsection