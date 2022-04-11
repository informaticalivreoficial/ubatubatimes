@extends('web.master.master')

@section('content')
<section class="utf_featured_post_area pt-4 no-padding">
      <div class="container">
          <div class="row">
              <div class="col-lg-8 col-md-12 pad-r">
                  @if (!empty($noticiasUbatuba && $noticiasUbatuba->count() > 0))
                      <div class="row">
                          @foreach ($noticiasUbatuba as $noticiau)
                              <div class="col-md-6 pb-4">
                                  <div class="utf_post_overaly_style contentTop hot-post-top clearfix">
                                        <div class="utf_post_thumb"> 
                                          <a href="{{route('web.noticia', ['slug' => $noticiau->slug ])}}">
                                            <img class="img-fluid" src="{{ $noticiau->cover() }}" alt="{{ $noticiau->titulo }}">
                                          </a> 
                                        </div>
                                        <div class="utf_post_content"> 
                                            <a class="utf_post_cat" href="#">Ubatuba</a>
                                            <h2 class="utf_post_title title-large"> 
                                              <a href="{{route('web.noticia', ['slug' => $noticiau->slug ])}}">{{ $noticiau->titulo }}</a> 
                                            </h2>
                                            <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $noticiau->views }}</span>	
                                            <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiau->created_at)->format('d/m/Y') }}</span> 
                                        </div>
                                  </div>
                              </div>
                          @endforeach
                      </div>
                  @endif 
              </div>

              <div class="col-lg-4 col-md-12 pad-l">
                  <div class="row">
                      <div class="col-md-12">
                          @if(!empty($boletim))
                              <div class="widget color-blue pl-3 pt-0">
                                  <h3 class="utf_block_title"><span>Boletim das Ondas - {{ Carbon\Carbon::parse($boletim->getContent()->atualizacao)->format('d/m/Y') }}</span></h3>                      
                                  <div class="utf_list_post_block">                       
                                      <h3 class="text-center mb-0">{{$boletim->getContent()->nome}}/{{$boletim->getContent()->uf}}</h3>
                                      <h4 style="float: left" class="mr-2">Manhã:</h3>
                                        <img  width="55" src="{{$boletim->ondasAlturaManha()['img']}}" alt="{{$boletim->ondasAlturaManha()['img']}}">    
                                      <ul class="list-round mr_bottom-20">
                                          <li>Situação do mar: {{$boletim->getContent()->manha->agitacao}}</li>
                                          <li>Altura das ondas: {{$boletim->ondasAlturaManha()['altura']}}</li>
                                          <li>Direção do mar: {{$boletim->getContent()->manha->direcao}}</li>
                                          <li>Vento: {{$boletim->getContent()->manha->vento}}</li>
                                          <li>Vento direção: {{$boletim->getContent()->manha->vento_dir}}</li>
                                      </ul>                                              
                                      <h4 style="float: left" class="mr-2">Tarde:</h3>
                                        <img  width="55" src="{{$boletim->ondasAlturaTarde()['img']}}" alt="{{$boletim->ondasAlturaTarde()['img']}}">    
                                      <ul class="list-round mr_bottom-20">
                                          <li>Situação do mar: {{$boletim->getContent()->tarde->agitacao}}</li>
                                          <li>Altura das ondas: {{$boletim->ondasAlturaTarde()['altura']}}</li>
                                          <li>Direção do mar: {{$boletim->getContent()->tarde->direcao}}</li>
                                          <li>Vento: {{$boletim->getContent()->tarde->vento}}</li>
                                          <li>Vento direção: {{$boletim->getContent()->tarde->vento_dir}}</li>
                                      </ul>                                       
                                  </div>
                              </div>
                          @endif
                      </div>
                  </div>
              </div>        
          </div>
      </div>
  </section>  
    

    <section class="utf_block_wrapper p-bottom-0">
        <div class="container">
            <div class="row">
                @if (!empty($noticiasCaragua && $noticiasCaragua->count() > 0))
                    <div class="col-lg-4">
                        <div class="block color-dark-blue">
                            <h3 class="utf_block_title"><span>Caraguatatuba</span></h3>
                            <div class="utf_post_overaly_style clearfix">
                                <div class="utf_post_thumb"> 
                                    <a href="{{route('web.noticia', [ 'slug' => $noticiasCaragua[0]->slug ])}}">
                                        <img class="img-fluid" src="{{$noticiasCaragua[0]->cover()}}" alt="{{$noticiasCaragua[0]->titulo}}" /> 
                                    </a> 
                                </div>
                                <div class="utf_post_content">
                                    <h2 class="utf_post_title"> 
                                      <a href="{{route('web.noticia', [ 'slug' => $noticiasCaragua[0]->slug ])}}">{{$noticiasCaragua[0]->titulo}}</a> 
                                    </h2>
                                    <div class="utf_post_meta"> 
                                      <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasCaragua[0]->views}}</span> 
                                      <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasCaragua[0]->created_at)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="utf_list_post_block">
                                <ul class="utf_list_post">
                                    @if (!empty($noticiasCaragua[1]))
                                        <li class="clearfix" style="min-height: 130px;">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasCaragua[1]->slug ])}}"> 
                                                    <img class="img-fluid" src="{{$noticiasCaragua[1]->cover()}}" alt="{{$noticiasCaragua[1]['titulo']}}" /> 
                                                  </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                <h2 class="utf_post_title title-small"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasCaragua[1]->slug ])}}">{{$noticiasCaragua[1]['titulo']}}</a> 
                                                </h2>
                                                <div class="utf_post_meta"> 
                                                  <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasCaragua[1]->views}}</span> 
                                                  <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasCaragua[1]->created_at)->format('d/m/Y') }}</span> 
                                                </div>
                                            </div>
                                        </li>
                                    @endif                                    
                                    @if (!empty($noticiasCaragua[2]))
                                        <li class="clearfix" style="min-height: 130px;">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasCaragua[2]->slug ])}}"> 
                                                    <img class="img-fluid" src="{{$noticiasCaragua[2]->cover()}}" alt="{{$noticiasCaragua[2]['titulo']}}" /> 
                                                  </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                <h2 class="utf_post_title title-small"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasCaragua[2]->slug ])}}">{{$noticiasCaragua[2]['titulo']}}</a> 
                                                </h2>
                                                <div class="utf_post_meta"> 
                                                  <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasCaragua[2]->views}}</span> 
                                                  <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasCaragua[2]->created_at)->format('d/m/Y') }}</span> 
                                                </div>
                                            </div>
                                        </li>
                                    @endif                                    
                                    @if (!empty($noticiasCaragua[3]))
                                        <li class="clearfix" style="min-height: 130px;">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasCaragua[3]->slug ])}}"> 
                                                    <img class="img-fluid" src="{{$noticiasCaragua[3]->cover()}}" alt="{{$noticiasCaragua[3]['titulo']}}" /> 
                                                  </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                <h2 class="utf_post_title title-small"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasCaragua[3]->slug ])}}">{{$noticiasCaragua[3]['titulo']}}</a> 
                                                </h2>
                                                <div class="utf_post_meta"> 
                                                  <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasCaragua[3]->views}}</span> 
                                                  <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasCaragua[3]->created_at)->format('d/m/Y') }}</span> 
                                                </div>
                                            </div>
                                        </li>
                                    @endif                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if (!empty($noticiasSaoSebastiao && $noticiasSaoSebastiao->count() > 0)) 
                    <div class="col-lg-4">
                        <div class="block color-aqua">
                            <h3 class="utf_block_title"><span>São Sebastião</span></h3>
                            <div class="utf_post_overaly_style clearfix">
                                <div class="utf_post_thumb"> 
                                    <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[0]->slug ])}}"> 
                                        <img class="img-fluid" src="{{$noticiasSaoSebastiao[0]->cover()}}" alt="{{$noticiasSaoSebastiao[0]->titulo}}" /> 
                                    </a> 
                                </div>
                                <div class="utf_post_content">
                                    <h2 class="utf_post_title"> 
                                      <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[0]->slug ])}}">{{$noticiasSaoSebastiao[0]->titulo}}</a> 
                                    </h2>
                                    <div class="utf_post_meta"> 
                                        <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasSaoSebastiao[0]->views}}</span> 
                                        <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasSaoSebastiao[0]->created_at)->format('d/m/Y') }}</span> 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="utf_list_post_block">
                                <ul class="utf_list_post">
                                    @if (!empty($noticiasSaoSebastiao[1]))
                                        <li class="clearfix" style="min-height: 130px;">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                    <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[1]->slug ])}}"> 
                                                        <img class="img-fluid" src="{{$noticiasSaoSebastiao[1]->cover()}}" alt="{{$noticiasSaoSebastiao[1]->titulo}}" /> 
                                                    </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                  <h2 class="utf_post_title title-small"> 
                                                    <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[1]->slug ])}}">{{$noticiasSaoSebastiao[1]->titulo}}</a> 
                                                  </h2>
                                                  <div class="utf_post_meta"> 
                                                      <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasSaoSebastiao[1]->views}}</span> 
                                                      <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasSaoSebastiao[1]->created_at)->format('d/m/Y') }}</span> 
                                                  </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($noticiasSaoSebastiao[2]))
                                        <li class="clearfix" style="min-height: 130px;">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                    <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[2]->slug ])}}"> 
                                                        <img class="img-fluid" src="{{$noticiasSaoSebastiao[2]->cover()}}" alt="{{$noticiasSaoSebastiao[2]->titulo}}" /> 
                                                    </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                <h2 class="utf_post_title title-small"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[2]->slug ])}}">{{$noticiasSaoSebastiao[2]->titulo}}</a> 
                                                </h2>
                                                <div class="utf_post_meta"> 
                                                    <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasSaoSebastiao[2]->views}}</span> 
                                                    <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasSaoSebastiao[2]->created_at)->format('d/m/Y') }}</span> </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($noticiasSaoSebastiao[3]))
                                        <li class="clearfix" style="min-height: 130px;">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                    <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[3]->slug ])}}"> 
                                                        <img class="img-fluid" src="{{$noticiasSaoSebastiao[3]->cover()}}" alt="{{$noticiasSaoSebastiao[3]->titulo}}" /> 
                                                    </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                <h2 class="utf_post_title title-small"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[3]->slug ])}}">{{$noticiasSaoSebastiao[3]->titulo}}</a> 
                                                </h2>
                                                <div class="utf_post_meta"> 
                                                    <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasSaoSebastiao[3]->views}}</span> 
                                                    <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasSaoSebastiao[3]->created_at)->format('d/m/Y') }}</span> </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif                                    
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
                @if (!empty($noticiasIlhabela && $noticiasIlhabela->count() > 0)) 
                    <div class="col-lg-4">
                        <div class="block color-violet">
                            <h3 class="utf_block_title"><span>Ilhabela</span></h3>
                            <div class="utf_post_overaly_style clearfix">
                                <div class="utf_post_thumb"> 
                                    <a href="{{route('web.noticia', [ 'slug' => $noticiasIlhabela[0]->slug ])}}"> 
                                        <img class="img-fluid" src="{{$noticiasIlhabela[0]->cover()}}" alt="{{$noticiasIlhabela[0]->titulo}}" /> 
                                    </a> 
                                </div>
                                <div class="utf_post_content">
                                    <h2 class="utf_post_title"> 
                                      <a href="{{route('web.noticia', [ 'slug' => $noticiasIlhabela[0]->slug ])}}">{{$noticiasIlhabela[0]->titulo}}</a> 
                                    </h2>
                                    <div class="utf_post_meta"> 
                                        <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasIlhabela[0]->views}}</span> 
                                        <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasIlhabela[0]->created_at)->format('d/m/Y') }}</span> 
                                    </div>
                                </div>
                            </div>
                            
                            <div class="utf_list_post_block">
                                <ul class="utf_list_post">
                                    @if (!empty($noticiasIlhabela[1]))
                                        <li class="clearfix" style="min-height: 130px;">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                    <a href="{{route('web.noticia', [ 'slug' => $noticiasIlhabela[1]->slug ])}}"> 
                                                        <img class="img-fluid" src="{{$noticiasIlhabela[1]->cover()}}" alt="{{$noticiasIlhabela[1]->titulo}}" /> 
                                                    </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                <h2 class="utf_post_title title-small"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasIlhabela[1]->slug ])}}">{{$noticiasIlhabela[1]->titulo}}</a> 
                                                </h2>
                                                <div class="utf_post_meta"> 
                                                  <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasIlhabela[1]->views}}</span> 
                                                  <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasIlhabela[1]->created_at)->format('d/m/Y') }}</span> </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($noticiasIlhabela[2]))
                                        <li class="clearfix" style="min-height: 130px;">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                    <a href="{{route('web.noticia', [ 'slug' => $noticiasIlhabela[2]->slug ])}}"> 
                                                        <img class="img-fluid" src="{{$noticiasIlhabela[2]->cover()}}" alt="{{$noticiasIlhabela[2]->titulo}}" /> 
                                                    </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                <h2 class="utf_post_title title-small"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasIlhabela[2]->slug ])}}">{{$noticiasIlhabela[2]->titulo}}</a> 
                                                </h2>
                                                <div class="utf_post_meta"> 
                                                  <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasIlhabela[2]->views}}</span> 
                                                  <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasIlhabela[2]->created_at)->format('d/m/Y') }}</span> </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($noticiasIlhabela[3]))
                                        <li class="clearfix" style="min-height: 130px;">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                    <a href="{{route('web.noticia', [ 'slug' => $noticiasIlhabela[3]->slug ])}}"> 
                                                        <img class="img-fluid" src="{{$noticiasIlhabela[3]->cover()}}" alt="{{$noticiasIlhabela[3]->titulo}}" /> 
                                                    </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                <h2 class="utf_post_title title-small"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasIlhabela[3]->slug ])}}">{{$noticiasIlhabela[3]->titulo}}</a> 
                                                </h2>
                                                <div class="utf_post_meta"> 
                                                  <span class="utf_post_author"><i class="fa fa-eye"></i> {{$noticiasIlhabela[3]->views}}</span> 
                                                  <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasIlhabela[3]->created_at)->format('d/m/Y') }}</span> </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>  
                @endif      
            </div>
        </div>
    </section>

    @if (!empty($artigos) && $artigos->count() > 0)
        <section class="utf_latest_new_area pb-bottom-20">
          <div class="container">
              <div class="utf_latest_news block color-red">
                  <h3 class="utf_block_title"><span>Blog</span></h3>
                  <div id="utf_latest_news_slide" class="owl-carousel owl-theme utf_latest_news_slide">
                      @foreach ($artigos as $artigo)
                          <div class="item">
                              <ul class="utf_list_post">                              
                                  <li class="clearfix">
                                      <div class="utf_post_block_style clearfix">
                                            <div class="utf_post_thumb"> 
                                                <a href="{{route('web.blog.artigo', [ 'slug' => $artigo->slug ])}}">
                                                    <img class="img-fluid" src="{{$artigo->cover()}}" alt="{{$artigo->titulo}}" />
                                                </a> 
                                            </div>
                                            <a class="utf_post_cat" href="#">{{$artigo->categoriaObject->titulo}}</a>
                                            <div class="utf_post_content">
                                                <h2 class="utf_post_title title-medium"> 
                                                    <a href="{{route('web.blog.artigo', [ 'slug' => $artigo->slug ])}}">{{$artigo->titulo}}</a> 
                                                </h2>
                                                <div class="utf_post_meta"> 
                                                    <span class="utf_post_author"><i class="fa fa-eye"></i> {{$artigo->views}}</span> 
                                                    <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($artigo->created_at)->format('d/m/Y') }}</span> 
                                                </div>
                                            </div>
                                      </div>
                                  </li>                     
                              </ul>			
                          </div>
                      @endforeach
                  </div>
                </div>
            </div>		
        </section>
    @endif
      
  
  <!-- Ad Content Area Start -->
  <div class="utf_ad_content_area text-center utf_banner_area no-padding">
    <div class="container">
      <div class="row">
        <div class="col-md-12"> <img class="img-fluid" src="images/banner-ads/ad-content-one.jpg" alt="" /> </div>
      </div>
    </div>
  </div>
  <!-- Ad Content Area End -->
  
  <!-- 1rd Block Wrapper Start -->
  <section class="utf_block_wrapper p-bottom-0">
    <div class="container">
      <div class="row">		
        <div class="col-lg-8 col-md-12">
          <div class="utf_featured_tab color-blue">
            <h3 class="utf_block_title"><span>Technology News</span></h3>
            <ul class="nav nav-tabs">
              <li class="nav-item"> <a class="nav-link animated fadeIn active" href="#tab_a" data-toggle="tab"> <span class="tab-head"> <span class="tab-text-title">Lifestyle</span> </span> </a> </li>
              <li class="nav-item"> <a class="nav-link animated fadeIn" href="#tab_b" data-toggle="tab"> <span class="tab-head"> <span class="tab-text-title">Traveling</span> </span> </a> </li>
            </ul>
            <div class="tab-content">
              <div class="tab-pane active animated fadeInRight" id="tab_a">
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <div class="utf_post_block_style clearfix">
                      <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/gadget1.jpg" alt="" /> </a> </div>
                      <a class="utf_post_cat" href="#">Lifestyle</a>
                      <div class="utf_post_content">
                        <h2 class="utf_post_title"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                        <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-lg-6 col-md-6">
                    <div class="utf_list_post_block">
                      <ul class="utf_list_post">
                        <li class="clearfix">
                          <div class="utf_post_block_style post-float clearfix">
                            <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/gadget2.jpg" alt="" /> </a> </div>                            
                            <div class="utf_post_content">
                              <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                              <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                            </div>
                          </div>
                        </li>
                        
                        <li class="clearfix">
                          <div class="utf_post_block_style post-float clearfix">
                            <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/gadget3.jpg" alt="" /> </a> </div>                            
                            <div class="utf_post_content">
                              <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                              <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                            </div>
                          </div>
                        </li>   
						
                        <li class="clearfix">
                          <div class="utf_post_block_style post-float clearfix">
                            <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/gadget4.jpg" alt="" /> </a> </div>                           
                            <div class="utf_post_content">
                              <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                              <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                            </div>
                          </div>
                        </li>
                        
                        <li class="clearfix">
                          <div class="utf_post_block_style post-float clearfix">
                            <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/gadget5.jpg" alt="" /> </a> </div>                            
                            <div class="utf_post_content">
                              <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                              <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                            </div>
                          </div>
                        </li>
                      </ul>
                    </div>
                  </div>
                </div>
              </div>
              
              <div class="tab-pane animated fadeInLeft" id="tab_b">
                <div class="row">
                  <div class="col-lg-6 col-md-6">
                    <div class="utf_post_block_style clearfix">
                      <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/robot1.jpg" alt="" /> </a> </div>
                      <a class="utf_post_cat" href="#">Traveling</a>
                      <div class="utf_post_content">
                        <h2 class="utf_post_title"> <a href="#">Ratcliffe to be Director nation intelligence Trump ignored...</a> </h2>
                        <div class="utf_post_meta"> <span class="utf_post_author"><a href="#">John Wick</a></span> <span class="utf_post_date">25 Jan, 2021</span> </div>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                      </div>
                    </div>
                  </div>
                  
                  <div class="col-lg-6 col-md-6">
                    <div class="utf_list_post_block">
                      <ul class="utf_list_post">
                        <li class="clearfix">
                          <div class="utf_post_block_style post-float clearfix">
                            <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/robot2.jpg" alt="" /> </a> </div>                            
                            <div class="utf_post_content">
                              <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                              <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                            </div>
                          </div>
                        </li>
                        
                        <li class="clearfix">
                          <div class="utf_post_block_style post-float clearfix">
                            <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/robot3.jpg" alt="" /> </a> </div>                            
                            <div class="utf_post_content">
                              <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                              <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                            </div>
                          </div>
                        </li>
                        
                        <li class="clearfix">
                          <div class="utf_post_block_style post-float clearfix">
                            <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/robot4.jpg" alt="" /> </a> </div>                            
                            <div class="utf_post_content">
                              <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                              <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                            </div>
                          </div>
                        </li>
                        
                        <li class="clearfix">
                          <div class="utf_post_block_style post-float clearfix">
                            <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/robot5.jpg" alt="" /> </a> </div>                            
                            <div class="utf_post_content">
                              <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                              <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                            </div>
                          </div>
                        </li>
                      </ul>                      
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
          <div class="gap-30"></div>
          <div class="block color-orange">
            <h3 class="utf_block_title"><span>Lifestyle News</span></h3>
            <div class="row">
              <div class="col-lg-6 col-md-6">
                <div class="utf_post_overaly_style clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/travel1.jpg" alt="" /> </a> </div>
                  <div class="utf_post_content"> <a class="utf_post_cat" href="#">Travel</a>
                    <h2 class="utf_post_title"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                  </div>
                </div>
                
                <div class="utf_list_post_block">
                  <ul class="utf_list_post">
                    <li class="clearfix">
                      <div class="utf_post_block_style post-float clearfix">
                        <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/food1.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Food</a> </div>                        
                        <div class="utf_post_content">
                          <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent... </a> </h2>
                          <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                        </div>
                      </div>
                    </li>
                    
                    <li class="clearfix">
                      <div class="utf_post_block_style post-float clearfix">
                        <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/health1.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Health</a> </div>                        
                        <div class="utf_post_content">
                          <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                          <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                        </div>
                      </div>
                    </li>
                    
                    <li class="clearfix">
                      <div class="utf_post_block_style post-float clearfix">
                        <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/travel2.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Travel</a> </div>
                        <div class="utf_post_content">
                          <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                          <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                        </div>                        
                      </div>                      
                    </li>
                    
                    <li class="clearfix">
                      <div class="utf_post_block_style post-float clearfix">
                        <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/architecture2.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Architecture</a> </div>
                        <div class="utf_post_content">
                          <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                          <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                        </div>
                      </div>
                    </li>                    
                  </ul>
                </div>
              </div>
              
              <div class="col-lg-6 col-md-6">
                <div class="utf_post_overaly_style last clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/architecture3.jpg" alt="" /> </a> </div>
                  <div class="utf_post_content"> <a class="utf_post_cat" href="#">Architecture</a>
                    <h2 class="utf_post_title"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                  </div>
                </div>
                
                <div class="utf_list_post_block">
                  <ul class="utf_list_post">
                    <li class="clearfix">
                      <div class="utf_post_block_style post-float clearfix">
                        <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/health2.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Health</a> </div>
                        <div class="utf_post_content">
                          <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                          <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                        </div>
                      </div>
                    </li>
                    
                    <li class="clearfix">
                      <div class="utf_post_block_style post-float clearfix">
                        <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/food2.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Food</a> </div>
                        <div class="utf_post_content">
                          <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                          <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                        </div>
                      </div>
                    </li>
                    
                    <li class="clearfix">
                      <div class="utf_post_block_style post-float clearfix">
                        <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/architecture1.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Architecture</a> </div>
                        <div class="utf_post_content">
                          <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                          <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                        </div>
                      </div>
                    </li>
                    
                    <li class="clearfix">
                      <div class="utf_post_block_style post-float clearfix">
                        <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/travel5.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Travel</a> </div>
                        <div class="utf_post_content">
                          <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                          <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-md-12">
          <div class="sidebar utf_sidebar_right">
            <div class="widget">
              <h3 class="utf_block_title"><span>Follow Us</span></h3>
              <ul class="social-icon">
                <li><a href="#" target="_blank"><i class="fa fa-rss"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa fa-facebook"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa fa-twitter"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa fa-google-plus"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa fa-vimeo-square"></i></a></li>
                <li><a href="#" target="_blank"><i class="fa fa-youtube"></i></a></li>
              </ul>
            </div>
            
            <div class="widget color-default">
              <h3 class="utf_block_title"><span>Popular News</span></h3>
              <div class="utf_post_overaly_style clearfix">
                <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/health4.jpg" alt="" /> </a> </div>
                <div class="utf_post_content"> <a class="utf_post_cat" href="#">Health</a>
                  <h2 class="utf_post_title"> <a href="#">Smart packs parking sensor tech and beeps when col…</a> </h2>
                  <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                </div>
              </div>
              
              <div class="utf_list_post_block">
                <ul class="utf_list_post">
                  <li class="clearfix">
                    <div class="utf_post_block_style post-float clearfix">
                      <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/gadget3.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Lifestyle</a> </div>                      
                      <div class="utf_post_content">
                        <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                        <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                      </div>
                    </div>
                  </li>
                  
                  <li class="clearfix">
                    <div class="utf_post_block_style post-float clearfix">
                      <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/travel5.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Travel</a> </div>
                      <div class="utf_post_content">
                        <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                        <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                      </div>
                    </div>
                  </li>
                  
                  <li class="clearfix">
                    <div class="utf_post_block_style post-float clearfix">
                      <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/robot5.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Traveling</a> </div>
                      <div class="utf_post_content">
                        <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                        <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                      </div>
                    </div>
                  </li>
                  
                  <li class="clearfix">
                    <div class="utf_post_block_style post-float clearfix">
                      <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/food1.jpg" alt="" /> </a> <a class="utf_post_cat" href="#">Food</a> </div>
                      <div class="utf_post_content">
                        <h2 class="utf_post_title title-small"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                        <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                      </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
            
            <div class="widget color-default m-bottom-0">
              <h3 class="utf_block_title"><span>Trending News</span></h3>
              <div id="utf_post_slide" class="owl-carousel owl-theme utf_post_slide">
                <div class="item">
                  <div class="utf_post_overaly_style text-center clearfix">
                    <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/gadget1.jpg" alt="" /> </a> </div>
                    <div class="utf_post_content"> <a class="utf_post_cat" href="#">Lifestyle</a>
                      <h2 class="utf_post_title"> <a href="#">The best MacBook Pro alternatives in 2021 for Appl…</a> </h2>
                      <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    </div>
                  </div>
                </div>
                
                <div class="item">
                  <div class="utf_post_overaly_style text-center clearfix">
                    <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/health5.jpg" alt="" /> </a> </div>
                    <div class="utf_post_content"> <a class="utf_post_cat" href="#">Health</a>
                      <h2 class="utf_post_title"> <a href="#">Netcix cuts out the chill with an integrated perso…</a> </h2>
                      <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
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
  <!-- 1rd Block Wrapper End -->
  
  
  <!-- 3rd Block Wrapper Start -->
  <section class="utf_block_wrapper p-bottom-0">
    <div class="container">
      <div class="row">
        <div class="col-lg-8 col-md-12">
          <div class="utf_more_news block color-default">
            <h3 class="utf_block_title"><span>View More News</span></h3>
            <div id="utf_more_news_slide" class="owl-carousel owl-theme utf_more_news_slide">
              <div class="item">
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/video/video1.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Video</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Ratcliffe to be Director of intelligence Trump ignored smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/game5.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Health</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Ratcliffe to be Director of intelligence Trump ignored smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/game4.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Health</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/robot5.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Traveling</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
				
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/game5.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Health</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Ratcliffe to be Director of intelligence Trump ignored smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
              </div>
              
              <div class="item">
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/video/video2.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Video</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Ratcliffe to be Director of intelligence Trump ignored smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/video/video3.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Video</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Breeze through 17 locations in Europe in this breathtaking v…</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/architecture1.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Architecture</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Science meets architecture in robotically woven, solar...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/game1.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Traveling</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Historical heroes and robot dinosaurs: New games on our…</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
              </div> 

			  <div class="item">
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/video/video1.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Video</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Ratcliffe to be Director of intelligence Trump ignored smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/game5.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Health</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Ratcliffe to be Director of intelligence Trump ignored smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/game4.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Health</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/robot5.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Traveling</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Zhang social media pop also known when smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
				
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/game5.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Health</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Ratcliffe to be Director of intelligence Trump ignored smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
              </div>
			  
			  <div class="item">
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/video/video2.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Video</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Ratcliffe to be Director of intelligence Trump ignored smart innocent...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/video/video3.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Video</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Breeze through 17 locations in Europe in this breathtaking v…</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/lifestyle/architecture1.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Architecture</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Science meets architecture in robotically woven, solar...</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
                
                <div class="utf_post_block_style utf_post_float_half clearfix">
                  <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/tech/game1.jpg" alt="" /> </a> </div>
                  <a class="utf_post_cat" href="#">Traveling</a>
                  <div class="utf_post_content">
                    <h2 class="utf_post_title"> <a href="#">Historical heroes and robot dinosaurs: New games on our…</a> </h2>
                    <div class="utf_post_meta"> <span class="utf_post_author"><i class="fa fa-user"></i> <a href="#">John Wick</a></span> <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> </div>
                    <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text since has five...</p>
                  </div>
                </div>
              </div>	
            </div>
          </div>
        </div>
        
        <div class="col-lg-4 col-sm-12">
          <div class="sidebar utf_sidebar_right">
            <div class="widget color-default">
              <h3 class="utf_block_title"><span>Latest Reviews</span></h3>
              <div class="utf_list_post_block">
                <ul class="utf_list_post review-post-list">
                  <li class="clearfix">
                    <div class="utf_post_block_style post-float clearfix">
                      <div class="utf_post_thumb"> <a href="#"> <img class="img-fluid" src="images/news/review/review1.jpg" alt="" /> </a> </div>                      
                      <div class="utf_post_content">
                        <h2 class="utf_post_title"> <a href="#">Zhang social media pop known innocent...</a> </h2>
                        <div class="utf_post_meta">
                          <div class="review-stars"> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star"></i> <i class="fa fa-star-half-o"></i> <i class="fa fa-star-o"></i> </div>
                        </div>
                      </div>
                    </div>
                  </li>
				  
				 
                </ul>
              </div>
            </div>
            
            <div class="widget m-bottom-0">
              <h3 class="utf_block_title"><span>Newsletter</span></h3>
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
          </div>
        </div>
      </div>
    </div>
  </section>  
  <!-- 3rd Block Wrapper End -->
  
  <!-- Ad Content Area Start -->
  <div class="utf_ad_content_area text-center utf_banner_area">
    <div class="container">
      <div class="row">
        <div class="col-md-12"> <img class="img-fluid" src="images/banner-ads/ad-content-two.png" alt="" /> </div>
      </div>
    </div>
  </div>
  <!-- Ad Content Area End -->

  
@endsection

@section('css')

@endsection

@section('js')

@endsection