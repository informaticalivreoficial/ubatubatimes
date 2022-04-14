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
              <div class="col-md-12"> 
                <img class="img-fluid" src="{{url(asset('frontend/assets/images/cavalo.png'))}}" alt="" /> 
              </div>
          </div>
      </div>
  </div>
  <!-- Ad Content Area End -->
  
@if (!empty($praiasDeUbatuba) && $praiasDeUbatuba->count() > 0)
  <section class="utf_block_wrapper p-bottom-0">
    <div class="container">
      <div class="row">		
          <div class="col-lg-8 col-md-12">
              <div class="utf_featured_tab color-blue">
                    <h3 class="utf_block_title"><span>Praias de Ubatuba</span></h3>  
                    <div class="row">
                        @if (!empty($praiasDeUbatuba[0]))
                          <div class="col-lg-6 col-md-6">
                              <div class="utf_post_block_style clearfix">
                                  <div class="utf_post_thumb"> 
                                      <a href="{{route('web.blog.artigo', [ 'slug' => $praiasDeUbatuba[0]->slug ])}}"> 
                                          <img class="img-fluid" src="{{$praiasDeUbatuba[0]->cover()}}" alt="{{$praiasDeUbatuba[0]->titulo}}" /> 
                                      </a> 
                                  </div>
                                  <a class="utf_post_cat" href="#"><i class="fa fa-eye"></i> {{$praiasDeUbatuba[0]->views}}</a>
                                  <div class="utf_post_content">
                                      <h2 class="utf_post_title"> 
                                          <a href="{{route('web.blog.artigo', [ 'slug' => $praiasDeUbatuba[0]->slug ])}}">{{$praiasDeUbatuba[0]->titulo}}</a> 
                                      </h2>
                                      <div class="utf_post_meta"> 
                                          <span class="utf_post_author"><i class="fa fa-user"></i> {{$praiasDeUbatuba[0]->user->name}}</span> 
                                          <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($praiasDeUbatuba[0]->created_at)->format('d/m/Y') }}</span> 
                                      </div>
                                      <p>{!! Words($praiasDeUbatuba[0]->content, 25) !!}</p>
                                  </div>
                              </div>
                          </div>
                        @endif                  
                      
                        <div class="col-lg-6 col-md-6">
                            <div class="utf_list_post_block">
                                <ul class="utf_list_post">
                                    @if (!empty($praiasDeUbatuba[1]))
                                        <li class="clearfix">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                    <a href="{{route('web.blog.artigo', [ 'slug' => $praiasDeUbatuba[1]->slug ])}}"> 
                                                        <img class="img-fluid" src="{{$praiasDeUbatuba[1]->cover()}}" alt="{{$praiasDeUbatuba[1]->titulo}}" /> 
                                                    </a> 
                                                </div>                            
                                                <div class="utf_post_content">
                                                    <h2 class="utf_post_title title-small"> 
                                                        <a href="{{route('web.blog.artigo', [ 'slug' => $praiasDeUbatuba[1]->slug ])}}">{{$praiasDeUbatuba[1]->titulo}}</a> 
                                                    </h2>
                                                    <div class="utf_post_meta"> 
                                                        <span class="utf_post_author"><i class="fa fa-eye"></i> {{$praiasDeUbatuba[1]->views}}</span> 
                                                        <span class="utf_post_date"><i class="fa fa-clock-o"></i>{{ Carbon\Carbon::parse($praiasDeUbatuba[1]->created_at)->format('d/m/Y') }}</span> 
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($praiasDeUbatuba[2]))
                                        <li class="clearfix">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                    <a href="{{route('web.blog.artigo', [ 'slug' => $praiasDeUbatuba[2]->slug ])}}"> 
                                                        <img class="img-fluid" src="{{$praiasDeUbatuba[2]->cover()}}" alt="{{$praiasDeUbatuba[2]->titulo}}" /> 
                                                    </a> 
                                                </div>                            
                                                <div class="utf_post_content">
                                                    <h2 class="utf_post_title title-small"> 
                                                        <a href="{{route('web.blog.artigo', [ 'slug' => $praiasDeUbatuba[2]->slug ])}}">{{$praiasDeUbatuba[2]->titulo}}</a> 
                                                    </h2>
                                                    <div class="utf_post_meta"> 
                                                        <span class="utf_post_author"><i class="fa fa-eye"></i> {{$praiasDeUbatuba[2]->views}}</span> 
                                                        <span class="utf_post_date"><i class="fa fa-clock-o"></i>{{ Carbon\Carbon::parse($praiasDeUbatuba[2]->created_at)->format('d/m/Y') }}</span> 
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($praiasDeUbatuba[3]))
                                        <li class="clearfix">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                    <a href="{{route('web.blog.artigo', [ 'slug' => $praiasDeUbatuba[3]->slug ])}}"> 
                                                        <img class="img-fluid" src="{{$praiasDeUbatuba[3]->cover()}}" alt="{{$praiasDeUbatuba[3]->titulo}}" /> 
                                                    </a> 
                                                </div>                            
                                                <div class="utf_post_content">
                                                    <h2 class="utf_post_title title-small"> 
                                                        <a href="{{route('web.blog.artigo', [ 'slug' => $praiasDeUbatuba[3]->slug ])}}">{{$praiasDeUbatuba[3]->titulo}}</a> 
                                                    </h2>
                                                    <div class="utf_post_meta"> 
                                                        <span class="utf_post_author"><i class="fa fa-eye"></i> {{$praiasDeUbatuba[3]->views}}</span> 
                                                        <span class="utf_post_date"><i class="fa fa-clock-o"></i>{{ Carbon\Carbon::parse($praiasDeUbatuba[3]->created_at)->format('d/m/Y') }}</span> 
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                    @if (!empty($praiasDeUbatuba[4]))
                                        <li class="clearfix">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                    <a href="{{route('web.blog.artigo', [ 'slug' => $praiasDeUbatuba[4]->slug ])}}"> 
                                                        <img class="img-fluid" src="{{$praiasDeUbatuba[4]->cover()}}" alt="{{$praiasDeUbatuba[4]->titulo}}" /> 
                                                    </a> 
                                                </div>                            
                                                <div class="utf_post_content">
                                                    <h2 class="utf_post_title title-small"> 
                                                        <a href="{{route('web.blog.artigo', [ 'slug' => $praiasDeUbatuba[4]->slug ])}}">{{$praiasDeUbatuba[4]->titulo}}</a> 
                                                    </h2>
                                                    <div class="utf_post_meta"> 
                                                        <span class="utf_post_author"><i class="fa fa-eye"></i> {{$praiasDeUbatuba[4]->views}}</span> 
                                                        <span class="utf_post_date"><i class="fa fa-clock-o"></i>{{ Carbon\Carbon::parse($praiasDeUbatuba[4]->created_at)->format('d/m/Y') }}</span> 
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>              
              </div>          
          </div>
        
          <div class="col-lg-4 col-md-12">
              <div class="sidebar utf_sidebar_right">  
                  @if (!empty($gastronomiaDeUbatuba) && $gastronomiaDeUbatuba->count() > 0)
                      <div class="widget color-default">
                          <h3 class="utf_block_title"><span>Gastronomia</span></h3> 
                          <div class="utf_list_post_block">
                              <ul class="utf_list_post">
                                @foreach ($gastronomiaDeUbatuba as $receita)
                                    <li class="clearfix">
                                      <div class="utf_post_block_style post-float clearfix">
                                          <div class="utf_post_thumb"> 
                                              <a href="{{route('web.blog.artigo', [ 'slug' => $receita->slug ])}}"> 
                                                  <img class="img-fluid" src="{{$receita->cover()}}" alt="{{$receita->titulo}}" /> 
                                              </a> 
                                          </div>                      
                                          <div class="utf_post_content">
                                              <h2 class="utf_post_title title-small"> 
                                                  <a href="{{route('web.blog.artigo', [ 'slug' => $receita->slug ])}}">{{$receita->titulo}}</a> 
                                              </h2>
                                              <div class="utf_post_meta"> 
                                                  <span class="utf_post_author"><i class="fa fa-eye"></i> {{$receita->views}}</span> 
                                                  <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($receita->created_at)->format('d/m/Y') }}</span> 
                                              </div>
                                          </div>
                                      </div>
                                    </li>
                                @endforeach
                              </ul>
                          </div>
                      </div>
                  @endif
              </div>
          </div>
      </div>
    </div>
  </section>
@endif

  
<div class="utf_ad_content_area text-center utf_banner_area">
    <div class="container">
        <div class="row">
            <div class="col-md-12"> 
                <img class="img-fluid" src="{{url(asset('frontend/assets/images/cavalo.png'))}}" alt="" /> 
            </div>
        </div>
    </div>
</div>

<ul id="rudr_instafeed"></ul>
  
@endsection

@section('css')

@endsection

@section('js')

@endsection