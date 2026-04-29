@extends('web.master.master')

@section('content')
<section class="utf_featured_post_area pt-4 no-padding">
      <div class="container">
          <div class="row">
              <div class="col-lg-8 col-md-12 pad-r">
                    @if ($noticiasUbatuba && $noticiasUbatuba->count() > 0)
                        <div class="row">
                            @foreach ($noticiasUbatuba as $noticiau)
                                <div class="col-md-6 pb-4">
                                    <div class="utf_post_overaly_style contentTop hot-post-top clearfix">
                                            <div class="utf_post_thumb"> 
                                            <a href="{{route('web.noticia', ['slug' => $noticiau->slug ])}}">
                                                <img class="img_person" src="{{ $noticiau->cover() }}" alt="{{ $noticiau->title }}">
                                            </a> 
                                            </div>
                                            <div class="utf_post_content"> 
                                                <a class="utf_post_cat" href="#">Ubatuba</a>
                                                <h2 class="utf_post_title title-large"> 
                                                <a href="{{route('web.noticia', ['slug' => $noticiau->slug ])}}">{{ $noticiau->title }}</a> 
                                                </h2>
                                                <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $noticiau->views }}</span>	
                                                <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiau->created_at)->format('d/m/Y') }}</span> 
                                            </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <div class="row">    
                        @if ($artigosDestaque && $artigosDestaque->count() > 0)                       
                            @foreach ($artigosDestaque as $artD)
                                <div class="col-md-6 pb-4">
                                    <div class="utf_post_overaly_style contentTop hot-post-top clearfix">
                                            <div class="utf_post_thumb"> 
                                            <a href="{{route('web.blog.artigo', ['slug' => $artD->slug ])}}">
                                                <img class="img_person" src="{{ $artD->cover() }}" alt="{{ $artD->title }}">
                                            </a> 
                                            </div>
                                            <div class="utf_post_content"> 
                                                <a class="utf_post_cat" href="#">{{$artD->categoryObject->title}}</a>
                                                <h2 class="utf_post_title title-large"> 
                                                <a href="{{route('web.blog.artigo', ['slug' => $artD->slug ])}}">{{ $artD->title }}</a> 
                                                </h2>
                                                <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $artD->views }}</span>	
                                                <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($artD->created_at)->format('d/m/Y') }}</span> 
                                            </div>
                                    </div>
                                </div>
                            @endforeach                       
                        @endif
                        @if ($estradas) 
                            <div class="col-md-6 pb-4">
                                <div class="utf_post_overaly_style contentTop hot-post-top clearfix">
                                        <div class="utf_post_thumb"> 
                                        <a href="{{route('web.noticia', ['slug' => $estradas->slug ])}}">
                                            <img class="img_person" src="{{ $estradas->cover() }}" alt="{{ $estradas->title }}">
                                        </a> 
                                        </div>
                                        <div class="utf_post_content"> 
                                            <a class="utf_post_cat" href="#">{{$estradas->categoryObject->title}}</a>
                                            <h2 class="utf_post_title title-large"> 
                                            <a href="{{route('web.noticia', ['slug' => $estradas->slug ])}}">{{ $estradas->title }}</a> 
                                            </h2>
                                            <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $estradas->views }}</span>	
                                            <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($estradas->created_at)->format('d/m/Y') }}</span> 
                                        </div>
                                </div>
                            </div>        
                        @endif
                    </div>
                  @if ($noticiasUbatuba1 && $noticiasUbatuba1->count() > 0)
                      <div class="row">
                          @foreach ($noticiasUbatuba1 as $noticiau1)
                              <div class="col-md-6 pb-4">
                                  <div class="utf_post_overaly_style contentTop hot-post-top clearfix">
                                        <div class="utf_post_thumb"> 
                                          <a href="{{route('web.noticia', ['slug' => $noticiau1->slug ])}}">
                                            <img class="img_person" src="{{ $noticiau1->cover() }}" alt="{{ $noticiau1->title }}">
                                          </a> 
                                        </div>
                                        <div class="utf_post_content"> 
                                            <a class="utf_post_cat" href="#">Ubatuba</a>
                                            <h2 class="utf_post_title title-large"> 
                                              <a href="{{route('web.noticia', ['slug' => $noticiau1->slug ])}}">{{ $noticiau1->title }}</a> 
                                            </h2>
                                            <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $noticiau1->views }}</span>	
                                            <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiau1->created_at)->format('d/m/Y') }}</span> 
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

                        @if (!empty($positionSidebarhome) && $positionSidebarhome->count() > 0)
                            @foreach($positionSidebarhome as $p)
                                <div class="widget text-center" style="background-color: #efefef; padding: 30px 0;">                                    
                                    <a href="{{$p->link ?? '#'}}" target="_blank">
                                        <img class="banner img-fluid" src="{{$p->get300x250()}}" alt="{{$p->title}}" />
                                    </a>                                                                      
                                </div>
                            @endforeach
                        @else
                            <div class="widget text-center" style="background-color: #efefef; padding: 30px 0;">                                    
                                <a href="{{route('web.anunciar')}}">
                                    <img class="banner img-fluid" src="{{url(asset('backend/assets/images/banner300x250.jpg'))}}" alt="Anuncie Aqui!" />
                                </a>                                                                      
                            </div>
                            <div class="widget text-center" style="background-color: #efefef; padding: 30px 0;">                                    
                                <a href="{{route('web.anunciar')}}">
                                    <img class="banner img-fluid" src="{{url(asset('backend/assets/images/banner300x250.jpg'))}}" alt="Anuncie Aqui!" />
                                </a>                                                                      
                            </div>
                            <div class="widget text-center" style="background-color: #efefef; padding: 30px 0;">                                    
                                <a href="{{route('web.anunciar')}}">
                                    <img class="banner img-fluid" src="{{url(asset('backend/assets/images/banner300x250.jpg'))}}" alt="Anuncie Aqui!" />
                                </a>                                                                      
                            </div>
                        @endif
                        
        
                          {{--@if(!empty($boletim))
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
                          @endif --}}
                      </div>
                  </div>
              </div>        
          </div>
      </div>
  </section>  
    

    <section class="utf_block_wrapper p-bottom-0">
        <div class="container">
            <div class="row">
                @if ($noticiasCaragua && $noticiasCaragua->count() > 0)
                    <div class="col-lg-4">
                        <div class="block color-dark-blue">
                            <h3 class="utf_block_title"><span>Caraguatatuba</span></h3>

                            {{-- Primeira notícia em destaque --}}
                            <div class="utf_post_overaly_style clearfix">
                                <div class="utf_post_thumb"> 
                                    <a href="{{ route('web.noticia', ['slug' => $noticiasCaragua[0]->slug]) }}">
                                        <img class="img_person" src="{{ $noticiasCaragua[0]->cover() }}" alt="{{ $noticiasCaragua[0]->title }}"/> 
                                    </a> 
                                </div>
                                <div class="utf_post_content">
                                    <h2 class="utf_post_title"> 
                                        <a href="{{ route('web.noticia', ['slug' => $noticiasCaragua[0]->slug]) }}">{{ $noticiasCaragua[0]->title }}</a> 
                                    </h2>
                                    <div class="utf_post_meta"> 
                                        <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $noticiasCaragua[0]->views }}</span> 
                                        <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasCaragua[0]->created_at)->format('d/m/Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Demais notícias em lista --}}
                            @if ($noticiasCaragua->count() > 1)
                                <div class="utf_list_post_block">
                                    <ul class="utf_list_post">
                                        @foreach ($noticiasCaragua->skip(1) as $noticia)
                                            <li class="clearfix" style="min-height: 130px;">
                                                <div class="utf_post_block_style post-float clearfix">
                                                    <div class="utf_post_thumb"> 
                                                        <a href="{{ route('web.noticia', ['slug' => $noticia->slug]) }}"> 
                                                            <img class="img-fluid" src="{{ $noticia->cover() }}" alt="{{ $noticia->title }}"/> 
                                                        </a> 
                                                    </div>                    
                                                    <div class="utf_post_content">
                                                        <h2 class="utf_post_title title-small"> 
                                                            <a href="{{ route('web.noticia', ['slug' => $noticia->slug]) }}">{{ $noticia->title }}</a> 
                                                        </h2>
                                                        <div class="utf_post_meta"> 
                                                            <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $noticia->views }}</span> 
                                                            <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y') }}</span> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

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
                                        <img class="img_person" src="{{$noticiasSaoSebastiao[0]->cover()}}" alt="{{$noticiasSaoSebastiao[0]->title}}" /> 
                                    </a> 
                                </div>
                                <div class="utf_post_content">
                                    <h2 class="utf_post_title"> 
                                      <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[0]->slug ])}}">{{$noticiasSaoSebastiao[0]->title}}</a> 
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
                                                        <img class="img_person_gastronomia" src="{{$noticiasSaoSebastiao[1]->cover()}}" alt="{{$noticiasSaoSebastiao[1]->title}}" /> 
                                                    </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                  <h2 class="utf_post_title title-small"> 
                                                    <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[1]->slug ])}}">{{$noticiasSaoSebastiao[1]->title}}</a> 
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
                                                        <img class="img_person_gastronomia" src="{{$noticiasSaoSebastiao[2]->cover()}}" alt="{{$noticiasSaoSebastiao[2]->title}}" /> 
                                                    </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                <h2 class="utf_post_title title-small"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[2]->slug ])}}">{{$noticiasSaoSebastiao[2]->title}}</a> 
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
                                                        <img class="img_person_gastronomia" src="{{$noticiasSaoSebastiao[3]->cover()}}" alt="{{$noticiasSaoSebastiao[3]->title}}" /> 
                                                    </a> 
                                                </div>                    
                                                <div class="utf_post_content">
                                                <h2 class="utf_post_title title-small"> 
                                                  <a href="{{route('web.noticia', [ 'slug' => $noticiasSaoSebastiao[3]->slug ])}}">{{$noticiasSaoSebastiao[3]->title}}</a> 
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
                @if ($noticiasIlhabela && $noticiasIlhabela->count() > 0)
                    <div class="col-lg-4">
                        <div class="block color-violet">
                            <h3 class="utf_block_title"><span>Ilhabela</span></h3>

                            {{-- Primeira notícia em destaque --}}
                            <div class="utf_post_overaly_style clearfix">
                                <div class="utf_post_thumb"> 
                                    <a href="{{ route('web.noticia', ['slug' => $noticiasIlhabela[0]->slug]) }}"> 
                                        <img class="img_person" src="{{ $noticiasIlhabela[0]->cover() }}" alt="{{ $noticiasIlhabela[0]->title }}" /> 
                                    </a> 
                                </div>
                                <div class="utf_post_content">
                                    <h2 class="utf_post_title"> 
                                        <a href="{{ route('web.noticia', ['slug' => $noticiasIlhabela[0]->slug]) }}">{{ $noticiasIlhabela[0]->title }}</a> 
                                    </h2>
                                    <div class="utf_post_meta"> 
                                        <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $noticiasIlhabela[0]->views }}</span> 
                                        <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticiasIlhabela[0]->created_at)->format('d/m/Y') }}</span> 
                                    </div>
                                </div>
                            </div>
                            
                            {{-- Demais notícias em lista --}}
                            @if ($noticiasIlhabela->count() > 1)
                                <div class="utf_list_post_block">
                                    <ul class="utf_list_post">
                                        @foreach ($noticiasIlhabela->skip(1) as $noticia)
                                            <li class="clearfix" style="min-height: 130px;">
                                                <div class="utf_post_block_style post-float clearfix">
                                                    <div class="utf_post_thumb"> 
                                                        <a href="{{ route('web.noticia', ['slug' => $noticia->slug]) }}"> 
                                                            <img class="img_person_gastronomia" src="{{ $noticia->cover() }}" alt="{{ $noticia->title }}" /> 
                                                        </a> 
                                                    </div>                    
                                                    <div class="utf_post_content">
                                                        <h2 class="utf_post_title title-small"> 
                                                            <a href="{{ route('web.noticia', ['slug' => $noticia->slug]) }}">{{ $noticia->title }}</a> 
                                                        </h2>
                                                        <div class="utf_post_meta"> 
                                                            <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $noticia->views }}</span> 
                                                            <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($noticia->created_at)->format('d/m/Y') }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                        </div>
                    </div>
                @endif      
            </div>
        </div>
    </section>

    @if ($artigos && $artigos->isNotEmpty())
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
                                                <a href="{{ route('web.blog.artigo', ['slug' => $artigo->slug]) }}">
                                                    <img class="img_person_blog" src="{{ $artigo->cover() }}" alt="{{ $artigo->title }}" />
                                                </a> 
                                            </div>
                                            <a class="utf_post_cat" href="#">{{ $artigo->categoryObject->title }}</a>
                                            <div class="utf_post_content">
                                                <h2 class="utf_post_title title-medium"> 
                                                    <a href="{{ route('web.blog.artigo', ['slug' => $artigo->slug]) }}">{{ $artigo->title }}</a> 
                                                </h2>
                                                <div class="utf_post_meta"> 
                                                    <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $artigo->views }}</span> 
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
      
  
    @if (!empty($positionMainhome) && $positionMainhome->count() > 0)
        @foreach($positionMainhome as $m)
            <div class="utf_ad_content_area text-center utf_banner_area no-padding">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12"> 
                            <a href="{{$m->link ?? '#'}}" target="_blank">
                                <img class="img-fluid" src="{{$m->get728x90()}}" alt="{{$m->title}}" /> 
                            </a> 
                        </div>
                    </div>
                </div>
            </div>            
        @endforeach
    @else
        <div class="utf_ad_content_area text-center utf_banner_area no-padding">  
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
  
@if ($praiasDeUbatuba && $praiasDeUbatuba->isNotEmpty())
<section class="utf_block_wrapper p-bottom-0">
    <div class="container">
        <div class="row">		
            <div class="col-lg-8 col-md-12">
                <div class="utf_featured_tab color-blue">
                    <h3 class="utf_block_title"><span>Praias de Ubatuba</span></h3>  
                    <div class="row">

                        {{-- Primeira praia em destaque --}}
                        <div class="col-lg-6 col-md-6">
                            <div class="utf_post_block_style clearfix">
                                <div class="utf_post_thumb"> 
                                    <a href="{{ route('web.blog.artigo', ['slug' => $praiasDeUbatuba[0]->slug]) }}"> 
                                        <img class="img_person" src="{{ $praiasDeUbatuba[0]->cover() }}" alt="{{ $praiasDeUbatuba[0]->title }}" /> 
                                    </a> 
                                </div>
                                <a class="utf_post_cat" href="#"><i class="fa fa-eye"></i> {{ $praiasDeUbatuba[0]->views }}</a>
                                <div class="utf_post_content">
                                    <h2 class="utf_post_title"> 
                                        <a href="{{ route('web.blog.artigo', ['slug' => $praiasDeUbatuba[0]->slug]) }}">{{ $praiasDeUbatuba[0]->title }}</a> 
                                    </h2>
                                    <div class="utf_post_meta"> 
                                        <span class="utf_post_author"><i class="fa fa-user"></i> {{ $praiasDeUbatuba[0]->user->name }}</span> 
                                        <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($praiasDeUbatuba[0]->created_at)->format('d/m/Y') }}</span> 
                                    </div>
                                    <p>{!! \App\Helpers\Renato::Words($praiasDeUbatuba[0]->content, 25) !!}</p>
                                </div>
                            </div>
                        </div>

                        {{-- Demais praias em lista --}}
                        @if ($praiasDeUbatuba->count() > 1)
                            <div class="col-lg-6 col-md-6">
                                <div class="utf_list_post_block">
                                    <ul class="utf_list_post">
                                        @foreach ($praiasDeUbatuba->skip(1) as $praia)
                                            <li class="clearfix">
                                                <div class="utf_post_block_style post-float clearfix">
                                                    <div class="utf_post_thumb"> 
                                                        <a href="{{ route('web.blog.artigo', ['slug' => $praia->slug]) }}"> 
                                                            <img class="img_person_gastronomia" src="{{ $praia->cover() }}" alt="{{ $praia->title }}" /> 
                                                        </a> 
                                                    </div>                            
                                                    <div class="utf_post_content">
                                                        <h2 class="utf_post_title title-small"> 
                                                            <a href="{{ route('web.blog.artigo', ['slug' => $praia->slug]) }}">{{ $praia->title }}</a> 
                                                        </h2>
                                                        <div class="utf_post_meta"> 
                                                            <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $praia->views }}</span> 
                                                            <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($praia->created_at)->format('d/m/Y') }}</span> 
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

            {{-- Sidebar Gastronomia --}}
            @if ($gastronomiaDeUbatuba && $gastronomiaDeUbatuba->isNotEmpty())
                <div class="col-lg-4 col-md-12">
                    <div class="sidebar utf_sidebar_right">  
                        <div class="widget color-default">
                            <h3 class="utf_block_title"><span>Gastronomia</span></h3> 
                            <div class="utf_list_post_block">
                                <ul class="utf_list_post">
                                    @foreach ($gastronomiaDeUbatuba as $receita)
                                        <li class="clearfix">
                                            <div class="utf_post_block_style post-float clearfix">
                                                <div class="utf_post_thumb"> 
                                                    <a href="{{ route('web.blog.artigo', ['slug' => $receita->slug]) }}"> 
                                                        <img class="img_person_gastronomia" src="{{ $receita->cover() }}" alt="{{ $receita->title }}" /> 
                                                    </a> 
                                                </div>                      
                                                <div class="utf_post_content">
                                                    <h2 class="utf_post_title title-small"> 
                                                        <a href="{{ route('web.blog.artigo', ['slug' => $receita->slug]) }}">{{ $receita->title }}</a> 
                                                    </h2>
                                                    <div class="utf_post_meta"> 
                                                        <span class="utf_post_author"><i class="fa fa-eye"></i> {{ $receita->views }}</span> 
                                                        <span class="utf_post_date"><i class="fa fa-clock-o"></i> {{ Carbon\Carbon::parse($receita->created_at)->format('d/m/Y') }}</span> 
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</section>
@endif

@if (!empty($positionFooterhome) && $positionFooterhome->count() > 0)
    @foreach($positionFooterhome as $f)
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
                    <a href="{{route('web.anunciar')}}" target="_blank">
                        <img class="img-fluid" src="{{url(asset('backend/assets/images/banner728x90.jpg'))}}" alt="Anuncie Aqui!" /> 
                    </a> 
                </div>
            </div>
        </div>                                                               
    </div>        
@endif  


<ul id="rudr_instafeed"></ul>
  
@endsection

@section('css')
<style>
    .img_person{
        min-height: 250px !important;
        max-height: 250px !important;
    }
    .img_person_blog{
        min-height: 170px !important;
        max-height: 170px !important;
    }
    .img_person_gastronomia{
        min-height: 75px !important;
        max-height: 75px !important;
        min-width: 100px !important;
    }
</style>
@endsection

@section('js')

@endsection