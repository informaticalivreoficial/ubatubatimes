<footer id="footer" class="footer">
    <div class="utf_footer_main">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-sm-12 col-xs-12 footer-widget contact-widget">
                        <h3 class="widget-title">Quem Somos</h3>
                        <ul>
                            <li>{{$config->information}}</li>
                            <li><i class="fa fa-home"></i> {{$config->city}} - {{$config->state}}</li>
                            @if ($config->phone)
                                <li><i class="fa fa-phone"></i> <a href="tel:{{$config->phone}}">{{$config->phone}}</a></li>
                            @endif
                            @if ($config->cell_phone)
                                <li><i class="fa fa-phone"></i> <a href="tel:{{$config->cell_phone}}">{{$config->cell_phone}}</a></li>
                            @endif
                            @if ($config->whatsapp)
                                <li><i class="fa fa-whatsapp"></i> <a target="_blank" href="{{\App\Helpers\WhatsApp::getNumZap($config->whatsapp ,$config->app_name)}}">{{$config->whatsapp}}</a></li>
                            @endif								
                            @if ($config->email)
                                <li><i class="fa fa-envelope-o"></i> <a href="mailto:{{$config->email}}">{{$config->email}}</a></li>
                            @endif
                            @if ($config->additional_email)
                                <li><i class="fa fa-envelope-o"></i> <a href="mailto:{{$config->additional_email}}">{{$config->additional_email}}</a></li>
                            @endif											 
                        </ul>
                        <ul class="unstyled utf_footer_social">
                            @if ($config->facebook)
                                <li><a target="_blank" href="{{$config->facebook}}" title="Facebook"><i class="fa fa-facebook"></i></a></li>
                            @endif
                            @if ($config->twitter)
                                <li><a target="_blank" href="{{$config->twitter}}" title="Twitter"><i class="fa fa-twitter"></i></a></li>
                            @endif
                            @if ($config->instagram)
                                <li><a target="_blank" href="{{$config->instagram}}" title="Instagram"><i class="fa fa-instagram"></i></a></li>
                            @endif
                            @if ($config->linkedin)
                                <li><a target="_blank" href="{{$config->linkedin}}" title="linkedin"><i class="fa fa-linkedin"></i></a></li>
                            @endif
                        </ul>
                </div>
            
            <div class="col-lg-4 col-sm-12 col-xs-12 footer-widget">
                <h3 class="widget-title">Links úteis</h3>
                <ul>
                    <li>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{route('web.guiaUbatuba')}}"><span class="catTitle">Guia Comercial Ubatuba</span></a> 
                    </li>
                    <li>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{route('web.anunciar')}}" target="_blank"><span class="catTitle">Anunciar</span></a> 
                    </li>
                    <li>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{route('web.blog.artigos')}}"><span class="catTitle">Blog</span></a> 
                    </li>
                    <li>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{route('web.pesquisa')}}"><span class="catTitle">Pesquisar no site</span></a> 
                    </li>
                    <li>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{route('web.noticias')}}"><span class="catTitle">Notícias</span></a> 
                    </li>
                    <li>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{route('web.ondas')}}"><span class="catTitle">Boletim das Ondas</span></a> 
                    </li>
                    <li>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{route('web.tempo')}}"><span class="catTitle">Previsão do Tempo</span></a> 
                    </li>
                    <li>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{route('web.blog.categoria', [ 'slug' => 'praias-de-ubatuba' ])}}"><span class="catTitle">Praias de Ubatuba</span></a> 
                    </li>
                    <li>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{route('web.blog.categoria', [ 'slug' => 'wiki-ubatuba' ])}}"><span class="catTitle">Wiki Ubatuba</span></a> 
                    </li>
                    <li>
                        <i class="fa fa-angle-double-right"></i>
                        <a href="{{route('web.politica')}}"><span class="catTitle">Política de Privacidade</span></a> 
                    </li>
                    <li>
                        <i class="fa fa-angle-double-right"></i>
                        <a @click="openModal()" class="hover:text-teal-400 transition cursor-pointer">Preferências de cookies</a>
                    </li>
                </ul>
            </div>
            
            <div class="col-lg-4 col-sm-12 col-xs-12 footer-widget">
                <h3 class="widget-title">Instagram Posts</h3>                            
            </div>
                        
            </div>
        </div>
    </div>    
</footer>