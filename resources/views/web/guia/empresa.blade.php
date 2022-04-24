@extends('web.master.master')


@section('content')

<div class="page-title">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><a href="{{route('web.home')}}">Início</a></li>
                    <li><a href="{{route('web.guiaUbatuba')}}">Guia</a></li>
                    <li>{{$empresa->alias_name}}</li>
                </ul>
            </div>
        </div>
    </div>
</div>    
  
  <section class="utf_block_wrapper">
    <div class="container">
      <div class="row">
                
          <div class="col-lg-4 col-md-12">
              <div class="sidebar utf_sidebar_right">

                  <div class="widget text-center"> 
                      <img class="banner img-fluid" src="{{$empresa->nocover()}}" alt="{{$empresa->alias_name}}" /> 
                  </div>

                  <div class="widget color-red">
                      <h3 class="utf_block_title"><span>Atendimento</span></h3>
                      <div class="utf_list_post_block">
                        <p>
                          <b>Email:</b> <a href="mailto:{{$empresa->email}}">{{$empresa->email}}</a><br>
                          <b>Website:</b> <a href="{{$empresa->dominio}}" target="_blank">{{$empresa->dominio}}</a><br>

                          @if ($empresa->telefone)
                            <b>Telefone:</b> <a href="tel:{{$empresa->telefone}}">{{$empresa->telefone}}</a><br>
                          @endif

                          @if ($empresa->celular)
                            <b>Telefone Móvel:</b> <a href="tel:{{$empresa->celular}}">{{$empresa->celular}}</a><br>
                          @endif

                          @if ($empresa->whatsapp)
                            <b>WhatsApp:</b> <a target="_blank" href="{{getNumZap($empresa->whatsapp ,$empresa->alias_name)}}">{{$empresa->whatsapp}}</a><br>
                          @endif
                          
                        </p>
                      </div>
                  </div>
                  
                  <div class="widget color-red">
                      <ul class="social-icon">
                          @if ($empresa->facebook)
                            <li><a href="{{$empresa->facebook}}" target="_blank"><i class="fa fa-facebook"></i></a></li>
                          @endif
                          @if ($empresa->twitter)
                            <li><a href="{{$empresa->twitter}}" target="_blank"><i class="fa fa-twitter"></i></a></li>
                          @endif
                          @if ($empresa->youtube)
                            <li><a href="{{$empresa->youtube}}" target="_blank"><i class="fa fa-youtube"></i></a></li>
                          @endif
                          @if ($empresa->instagram)
                            <li><a href="{{$empresa->instagram}}" target="_blank"><i class="fa fa-instagram"></i></a></li>
                          @endif                
                          @if ($empresa->linkedin)
                            <li><a href="{{$empresa->linkedin}}" target="_blank"><i class="fa fa-linkedin"></i></a></li>
                          @endif                
                      </ul>
                  </div>

                  <div class="widget color-red">
                      {!!$empresa->mapa_google!!}
                  </div>

              </div>
          </div>
          
          <div class="col-lg-8 col-md-12">
            <div class="single-post">
                  <div class="utf_post_title-area"> 
                      <a class="utf_post_cat" href="#">{{$empresa->categoriaObject->titulo}}</a>
                      <h2 class="utf_post_title">{{$empresa->alias_name}}</h2>
                      <div class="utf_post_meta"> 
                          <span class="post-hits"><i class="fa fa-eye"></i> {{$empresa->views}}</span>  
                          <div class="fb-share-button" data-href="{{url()->current()}}" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Compartilhar</a></div>
                          <a class="btn-front" target="_blank" href="https://web.whatsapp.com/send?text={{url()->current()}}" data-action="share/whatsapp/share"><i class="fa fa-whatsapp"></i> Compartilhar</a>
                      </div>
                  </div>
              
                  <div class="utf_post_content-area">              
                      <div class="entry-content">
                            {!!$empresa->content!!}
                            @if($empresa->images()->get()->count()) 
                              <div class="row mt-3">                   
                                  @foreach($empresa->images()->get() as $image) 
                                      @if ($image->cover == null)
                                        <div class="col-4 mb-3">
                                          <div class="utf_post_thumb">                            
                                              <a href="{{ $image->url_image }}" class="gallery-popup">
                                                  <img class="img-fluid" src="{{ $image->url_cropped }}" alt="{{ $empresa->alias_name }}"> 
                                              </a>                            
                                          </div>
                                        </div>
                                      @endif                                                
                                  @endforeach 
                              </div>                               
                          @endif
                      </div>                                  
                  </div>
            </div>
            
      
            <div class="comments-form">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" name="nome" placeholder="Nome" type="text">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <input class="form-control" name="email" placeholder="Email" type="email">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group">
                                <textarea class="form-control" name="mensagem" placeholder="Mensagem" rows="10"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix">
                        <button class="comments-btn btn btn-primary" type="submit">Enviar Mensagem</button>
                    </div>
                </form>
            </div>
                   
        </div>
        
        
      </div>

        @if (!empty($empresas) && $empresas->count() > 0)
          <div class="row mt-5">
              <div class="col-12">
                  <div class="related-posts block">
                      <h3 class="utf_block_title"><span>Veja Também</span></h3>
                      <div id="utf_latest_news_slide" class="owl-carousel owl-theme utf_latest_news_slide">
                          @foreach ($empresas as $item)
                              @if ($item->anuncios()->count() > 0)
                                <div class="item">
                                    <div class="utf_post_block_style clearfix">
                                        <div class="imgbox"> 
                                            <a href="{{route('web.guiaEmpresa',[ 'slug' => $item->slug ])}}">
                                                <img style="max-width: 150px;" class="img-fluid" src="{{$item->logoCover()}}" alt="{{$item->alias_name}}" />
                                            </a> 
                                        </div>
                                        <div class="utf_post_content">
                                            <h2 class="utf_post_title title-medium"> 
                                                <a href="{{route('web.guiaEmpresa',[ 'slug' => $item->slug ])}}">{{$item->alias_name}}</a> 
                                            </h2>
                                            <div class="utf_post_meta"> 
                                                <span class="utf_post_date"><i class="fa fa-clock-o"></i> 25 Jan, 2021</span> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              @endif                              
                          @endforeach      
                      </div>            
                  </div>
              </div>
          </div>
        @endif
        

    </div>
  </section>

@endsection

@section('css')
    <style>
        iframe{
          width: 100%; 
          min-height: 400px;
        }
        .imgbox img{
            max-width: 150px;
            min-height: 75px;
            border-radius: 2px;
            box-shadow: 0 2px 3px rgb(0 0 0 / 10%);
        }
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