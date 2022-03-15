@extends('web.master.master')

@section('content')
<div class="row">
    <div class="col-md-8">
        @if (!empty($noticiasubatuba && count($noticiasubatuba) > 0))
        <div class="featured-posts gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                                    
            <div class="content-left">
                <article class="post">
                    <div class="thumb">
                        <a href="noticia/{{ $noticiasubatuba[0]['local'] }}/@php
                            $link = explode('/', $noticiasubatuba[0]['url']);
                            echo $link[3].'/'.$link[4];
                        @endphp
                        "><img src="{{ $noticiasubatuba[0]['img'] }}" alt="{{ $noticiasubatuba[0]['titulo'] }}"></a>
                    </div>
                    <div class="cat">
                        <a href="">Mustreads</a>
                    </div>
                    <h3><a href="noticia/{{ $noticiasubatuba[0]['local'] }}/@php
                        $link = explode('/', $noticiasubatuba[0]['url']);
                        echo $link[3].'/'.$link[4];
                    @endphp
                    ">{{ $noticiasubatuba[0]['titulo'] }}</a></h3>
                    <p class="excerpt-entry">{{ $noticiasubatuba[0]['content'] }}</p>
                    <div class="post-meta">
                        <span class="author">By <a href="#">Paul Graham</a></span>
                        <div class="activity">
                            <span class="views">345</span><span class="comment"><a href="#">15</a></span>
                        </div>
                    </div>
                </article><!--  /.post -->
            </div>
            
            <div class="content-right">
                <article class="post">
                    <div class="thumb">
                        <a href="noticia/{{ $noticiasubatuba[1]['local'] }}/@php
                        $link = explode('/', $noticiasubatuba[1]['url']);
                        echo $link[3].'/'.$link[4];
                    @endphp
                    "><img src="{{ $noticiasubatuba[1]['img'] }}" alt="img"></a>
                    </div>
                    <div class="cat">
                        <a href="">Tech</a>
                    </div>
                    <h3><a href="noticia/{{ $noticiasubatuba[1]['local'] }}/@php
                        $link = explode('/', $noticiasubatuba[1]['url']);
                        echo $link[3].'/'.$link[4];
                    @endphp
                    ">{{ $noticiasubatuba[1]['titulo'] }}</a></h3>
                    <div class="activity">
                        <span class="views">12</span><span class="comment"><a href="#">15</a></span>
                    </div>
                </article>
                <article class="post">
                    <div class="thumb">
                        <a href="noticia/{{ $noticiasubatuba[2]['local'] }}/@php
                        $link = explode('/', $noticiasubatuba[2]['url']);
                        echo $link[3].'/'.$link[4];
                    @endphp
                    "><img src="{{ $noticiasubatuba[2]['img'] }}" alt="img"></a>
                    </div>
                    <div class="cat">
                        <a href="">Social media</a>
                    </div>
                    <h3><a href="noticia/{{ $noticiasubatuba[2]['local'] }}/@php
                        $link = explode('/', $noticiasubatuba[2]['url']);
                        echo $link[3].'/'.$link[4];
                    @endphp
                    ">{{ $noticiasubatuba[2]['titulo'] }}</a></h3>
                    <div class="activity">
                        <span class="views">12</span><span class="comment"><a href="#">15</a></span>
                    </div>
                </article>
            </div>
            
        </div>
        @endif
        
        <div class="highlights-posts gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
            <div class="gn-line"></div>
            <div class="section-title">
                <h4><a href="#">Região</a></h4>
            </div>
            <article class="post">
                <div class="thumb">
                    <a href="#"><img src="images/thumbs/7.jpg" alt="img"></a>
                </div>
                <div class="cat">
                    <a href="">Social media</a>
                </div>
                <h3><a href="#">Like all back-of-the-envelope calculations, this one has a lot of wiggle room.</a></h3>
                <div class="activity">
                    <span class="views">12</span><span class="comment"><a href="#">0</a></span>
                </div>
            </article><!--  /.post -->
            <article class="post last">
                <div class="thumb">
                    <a href="#"><img src="images/thumbs/7-3.jpg" alt="img"></a>
                </div>
                <div class="cat">
                    <a href="">Social media</a>
                </div>
                <h3><a href="#">I'm not claiming the multiplier is precisely 36, but it is certainly more than 10...</a></h3>
                <div class="activity">
                    <span class="views">12</span><span class="comment"><a href="#">0</a></span>
                </div>
            </article><!--  /.post -->
            <article class="post">
                <div class="thumb">
                    <a href="#"><img src="images/thumbs/7-2.jpg" alt="img"></a>
                </div>
                <div class="cat">
                    <a href="">Social media</a>
                </div>
                <h3><a href="#">Like all back-of-the-envelope calculations, this one has a lot of wiggle room.</a></h3>
                <div class="activity">
                    <span class="views">12</span><span class="comment"><a href="#">0</a></span>
                </div>
            </article><!--  /.post -->
            <article class="post margin-b0 last">
                <div class="thumb">
                    <a href="#"><img src="images/thumbs/7-4.jpg" alt="img"></a>
                </div>
                <div class="cat">
                    <a href="">Social media</a>
                </div>
                <h3><a href="#">I'm not claiming the multiplier is precisely 36, but it is certainly more than 10...</a></h3>
                <div class="activity">
                    <span class="views">12</span><span class="comment"><a href="#">0</a></span>
                </div>
            </article><!--  /.post -->
        </div><!-- /.highlights-posts -->
        <div class="editors-posts gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
            <div class="gn-line"></div>
            <div class="section-title">
                <h4><a href="#">Editors Picks</a></h4>
            </div>
            <div class="post-wrap">
                <article class="post">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/3.jpg" alt="img"></a>
                    </div>
                    <div class="content">
                        <div class="cat">
                            <a href="">Mustreads</a>
                        </div>
                        <h3><a href="#">If you wanted to get rich, how would you do it?</a></h3>
                        <p class="excerpt-entry">Economically, you can think of a startup as a way to compress your whole working life into a few years.</p>
                        <div class="post-meta">
                            <span class="author">By <a href="#">Anna Chapman</a></span>
                            <span class="time"> - 16 hours ago</span>
                        </div>
                    </div>
                </article><!--  /.post -->
                <article class="post">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/3-2.jpg" alt="img"></a>
                    </div>
                    <div class="content">
                        <div class="cat">
                            <a href="">Mustreads</a>
                        </div>
                        <h3><a href="#">If you wanted to get rich, how would you do it?</a></h3>
                        <p class="excerpt-entry">Instead of working at a low intensity for forty years, you work as hard as you possibly can for four.</p>
                        <div class="post-meta">
                            <span class="author">By <a href="#">John Doe</a></span>
                            <span class="time"> - 16 hours ago</span>
                        </div>
                    </div>
                </article><!--  /.post -->
                <article class="post">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/3-3.jpg" alt="img"></a>
                    </div>
                    <div class="content">
                        <div class="cat">
                            <a href="">Mustreads</a>
                        </div>
                        <h3><a href="#">If you wanted to get rich, how would you do it?</a></h3>
                        <p class="excerpt-entry">I think your best bet would be to start or join a startup. </p>
                        <div class="post-meta">
                            <span class="author">By <a href="#">Mike Tyson</a></span>
                            <span class="time"> - 16 hours ago</span>
                        </div>
                    </div>
                </article><!--  /.post -->
            </div><!-- /.post-wrap -->
        </div><!-- /.editors-posts -->
        <div class="popular-posts gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
            <div class="gn-line"></div>
            <div class="section-title">
                <h4><a href="#">Popular Posts</a></h4>
            </div>	
            <div class="content-left">
                <article class="post">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/8.jpg" alt="img"></a>
                    </div>
                    <div class="cat">
                        <a href="">Mustreads</a>
                    </div>
                    <h3><a href="#">If you wanted to get rich</a></h3>
                    <p class="excerpt-entry">I think your best bet would be to start or join a startup. That's been a reliable way to get rich for hundreds of years.The word "startup" dates from the 1960s, but what happens in one is very similar.</p>
                    <div class="post-meta">
                        <span class="author">By <a href="#">John Doe</a></span>
                        <div class="activity">
                            <span class="views">345</span><span class="comment"><a href="#">15</a></span>
                        </div>
                    </div>
                </article><!--  /.post -->
            </div><!-- /.content-left -->
            <div class="content-right">
                <article class="post">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/2.jpg" alt="img"></a>
                    </div>
                    <div class="content">
                        <h3><a href="#">Lots of people get rich knowing nothing more than that.</a></h3>
                        <span class="date">7:00 am on Feb 28</span>
                    </div>
                </article><!--  /.post -->
                <article class="post">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/2-2.jpg" alt="img"></a>
                    </div>
                    <div class="content">
                        <h3><a href="#">Lots of people get rich knowing nothing more than that.</a></h3>
                        <span class="date">7:00 am on Feb 28</span>
                    </div>
                </article><!--  /.post -->
                <article class="post">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/2-3.jpg" alt="img"></a>
                    </div>
                    <div class="content">
                        <h3><a href="#">Lots of people get rich knowing nothing more than that.</a></h3>
                        <span class="date">7:00 am on Feb 28</span>
                    </div>
                </article><!--  /.post -->
                <article class="post">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/2-4.jpg" alt="img"></a>
                    </div>
                    <div class="content">
                        <h3><a href="#">Lots of people get rich knowing nothing more than that.</a></h3>
                        <span class="date">7:00 am on Feb 28</span>
                    </div>
                </article><!--  /.post -->
                <article class="post">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/2-5.jpg" alt="img"></a>
                    </div>
                    <div class="content">
                        <h3><a href="#">Lots of people get rich knowing nothing more than that.</a></h3>
                        <span class="date">7:00 am on Feb 28</span>
                    </div>
                </article><!--  /.post -->
                <article class="post">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/2-6.jpg" alt="img"></a>
                    </div>
                    <div class="content">
                        <h3><a href="#">Lots of people get rich knowing nothing more than that.</a></h3>
                        <span class="date">7:00 am on Feb 28</span>
                    </div>
                </article><!--  /.post -->
            </div><!-- /.content-right -->
        </div><!-- /.popular-posts -->
    </div><!-- /.col-md-8 -->
    <div class="col-md-4">
        <div class="sidebar-widget-1">
            <div class="widget widget-recent gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                <h5 class="widget-title">Recent Posts</h5>
                <ul>
                    <li>
                        <div class="thumb">
                            <a href=""><img src="images/thumbs/2.jpg" alt="img"></a>
                        </div>
                        <div class="content">
                            <h3><a href="#">Lots of people get rich knowing nothing more than that.</a></h3>
                            <div class="date">7:00 am on Feb 28</div>
                        </div>
                    </li>
                    <li>
                        <div class="thumb">
                            <a href=""><img src="images/thumbs/2-2.jpg" alt="img"></a>
                        </div>
                        <div class="content">
                            <h3><a href="#">Lots of people get rich knowing nothing more than that.</a></h3>
                            <div class="date">7:00 am on Feb 28</div>
                        </div>
                    </li>
                    <li>
                        <div class="thumb">
                            <a href=""><img src="images/thumbs/2-3.jpg" alt="img"></a>
                        </div>
                        <div class="content">
                            <h3><a href="#">Lots of people get rich knowing nothing more than that.</a></h3>
                            <div class="date">7:00 am on Feb 28</div>
                        </div>
                    </li>
                </ul>
            </div><!-- /.widget-recent -->
            <div class="widget widget-ads gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                <a href="#"><img src="images/ad.jpg" alt="image"></a>
                <p class="text-ad">Advertisement</p>
            </div><!-- /.widget-ads -->
            <div class="widget widget-most-popular gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                <h5 class="widget-title">5 Most Popular</h5>
                <ul>
                    <li>
                        <div class="order">1</div>
                        <p><a href="">The World’s Youngest Billionaire is Just 24 and She’s From Hong Kong</a></p>
                    </li>
                    <li>
                        <div class="order">2</div>
                        <p><a href="">The World’s Youngest Billionaire is Just 24 and She’s From Hong Kong</a></p>
                    </li>
                    <li>
                        <div class="order">3</div>
                        <p><a href="">The World’s Youngest Billionaire is Just 24 and She’s From Hong Kong</a></p>
                    </li>
                    <li>
                        <div class="order">4</div>
                        <p><a href="">The World’s Youngest Billionaire is Just 24 and She’s From Hong Kong</a></p>
                    </li>
                    <li>
                        <div class="order">5</div>
                        <p><a href="">The World’s Youngest Billionaire is Just 24 and She’s From Hong Kong</a></p>
                    </li>
                </ul>
            </div><!-- /.widget-popular -->
            <div class="widget widget-tabs gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                <div class="tabs">
                    <ul class="menu-tab">
                        <li class="active"><a href="#">Comments</a></li>
                            <li><a href="#">Popular</a></li>
                            <li><a href="#">Tags</a></li>
                    </ul><!-- /.menu-tab -->
                    <div class="content-tab">
                            <div class="content">
                            <ul class="comments">
                                <li>
                                    <div class="avatar">
                                        <a href="#"><img src="images/user.jpg" alt="image"></a>
                                    </div>
                                    <p><a href="#">Jack</a> on <a href="#">I think your best bet would be to start or join a startup.</a> 2 hours</p>
                                </li>	
                                <li>
                                    <div class="avatar">
                                        <a href="#"><img src="images/user.jpg" alt="image"></a>
                                    </div>
                                    <p><a href="#">Jack</a> on <a href="#">I think your best bet would be to start or join a startup.</a> 2 hours</p>
                                </li>
                                <li>
                                    <div class="avatar">
                                        <a href="#"><img src="images/user.jpg" alt="image"></a>
                                    </div>
                                    <p><a href="#">Jack</a> on <a href="#">I think your best bet would be to start or join a startup.</a> 2 hours</p>
                                </li>
                                <li>
                                    <div class="avatar">
                                        <a href="#"><img src="images/user.jpg" alt="image"></a>
                                    </div>
                                    <p><a href="#">Jack</a> on <a href="#">I think your best bet would be to start or join a startup.</a> 2 hours</p>
                                </li>
                                <li>
                                    <div class="avatar">
                                        <a href="#"><img src="images/user.jpg" alt="image"></a>
                                    </div>
                                    <p><a href="#">Jack</a> on <a href="#">I think your best bet would be to start or join a startup.</a> 2 hours</p>
                                </li>
                            </ul>
                            </div><!-- /.comments -->
                            <div class="content">
                            <ul class="pop-posts">
                                <li>
                                    <div class="thumb">
                                        <a href="#"><img alt="" src="images/thumbs/1.jpg"></a>
                                    </div>
                                    <div class="text">
                                        <a href="#">If you wanted to get rich, how would you do it?</a>
                                        <i>Aug 1, 2014</i>
                                    </div>
                                </li>
                                <li>
                                    <div class="thumb">
                                        <a href="#"><img alt="" src="images/thumbs/1-2.jpg"></a>
                                    </div>
                                    <div class="text">
                                        <a href="#">If you wanted to get rich, how would you do it?</a>
                                        <i>Aug 1, 2014</i>
                                    </div>
                                </li>
                                <li>
                                    <div class="thumb">
                                        <a href="#"><img alt="" src="images/thumbs/1-3.jpg"></a>
                                    </div>
                                    <div class="text">
                                        <a href="#">If you wanted to get rich, how would you do it?</a>
                                        <i>Aug 1, 2014</i>
                                    </div> 
                                </li>
                                <li>
                                    <div class="thumb">
                                        <a href="#"><img alt="" src="images/thumbs/1-4.jpg"></a>
                                    </div>
                                    <div class="text">
                                        <a href="#">If you wanted to get rich, how would you do it?</a>
                                        <i>Aug 1, 2014</i>
                                    </div> 
                                </li>
                                <li>
                                    <div class="thumb">
                                        <a href="#"><img alt="" src="images/thumbs/1-5.jpg"></a>
                                    </div>
                                    <div class="text">
                                        <a href="#">If you wanted to get rich, how would you do it?</a>
                                        <i>Aug 1, 2014</i>
                                    </div>
                                </li>
                            </ul>
                            </div><!-- /.comments -->
                            <div class="content">
                            <div class="tags">
                                <a href="#">business</a>
                                <a href="#">themeforest</a>
                                <a href="#">good news</a>
                                <a href="#">startups</a>
                                <a href="#">red</a>
                                <a href="#">politics</a>
                                <a href="#">europe</a>
                                <a href="#">asia</a>
                            </div>
                            </div><!-- /.comments -->
                    </div><!-- /.content-tab -->
                </div><!-- /.tabs -->
            </div><!-- /.widget-tabs -->
            <div class="widget widget-follow-us gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                <h5 class="widget-title text-dark">Follow Us</h5>
                <div class="socials">
                    <a class="facebook" href="#"><i class="fa fa-facebook"></i></a>
                    <a class="twitter" href="#"><i class="fa fa-twitter"></i></a>
                    <a class="google" href="#"><i class="fa fa-google-plus"></i></a>
                    <a class="youtube" href="#"><i class="fa fa-youtube"></i></a>
                    <a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a>
                    <a class="tumblr" href="#"><i class="fa fa-tumblr"></i></a>
                </div>
            </div><!-- /.widget-follow-us -->
            <div class="widget widget-categories gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                <h5 class="widget-title">Archives</h5>
                <ul class="cat-list">
                    <li><a href="#">December 2013 <span>(0)</span></a></li>
                    <li><a href="#">November 2013 <span>(22)</span></a></li>
                    <li><a href="#">October 2013 <span>(17)</span></a></li>
                    <li><a href="#">June 2013 <span>(16)</span></a></li>
                    <li><a href="#">May 2013 <span>(14)</span></a></li>
                    <li><a href="#">April 2013 <span>(10)</span></a></li>
                    <li><a href="#">March 2013 <span>(1)</span></a></li>
                    <li><a href="#">December 2012 <span>(1)</span></a></li>
                </ul>
            </div><!-- /.widget-categories -->
            <div class="widget widget-subscribe gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                <h5 class="widget-title">Good News Newsetter</h5>
                <p>Subscribe to our email newsletter for good news, sent out every Monday.</p>
                <form method="post" action="#" id="subscribe-form" data-mailchimp="true">
                    <div id="subscribe-content">
                        <div class="input">
                            <input type="text" id="subscribe-email" name="subscribe-email" placeholder="Email">
                        </div>
                        <div class="button">
                            <button type="button" id="subscribe-button" class="" title="Subscribe now">Subscribe</button>
                        </div>
                    </div>
                    <div id="subscribe-msg"></div>
                </form>
            </div><!-- /.widget-subscribe -->
        </div><!-- /.sidebar -->
    </div><!-- /.col-md-4 -->
    <div class="col-md-12">
        <div class="gnSlider gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
            <div class="flex-container">
                <div class="flexslider loading">
                    <ul class="slides">
                        <li>
                            <div class="item-wrap">
                                <img src="images/slider/1.jpg" alt="image">
                                <p class="item" data-bottomtext="0">Kenneth Cole Challenges You to Do Good Deeds — and Prove it via Google Glass</p>
                            </div>
                        </li>
                        <li>
                            <div class="item-wrap">
                                <img src="images/slider/2.jpg" alt="image">
                                <p class="item" data-bottomtext="0">Kenneth Cole Challenges You to Do Good Deeds — and Prove it via Google Glass</p>
                            </div>
                        </li>
                        <li>
                            <div class="item-wrap">
                                <img src="images/slider/3.jpg" alt="image">
                                <p class="item" data-bottomtext="0">Kenneth Cole Challenges You to Do Good Deeds — and Prove it via Google Glass</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div><!-- /.gnSlider -->
    </div><!-- /.col-md-12 -->
    <div class="col-md-12">
        <div class="trending-posts">
            <div class="gn-line"></div>
            <div class="section-title">
                <h4><a href="#">Trending</a></h4>
            </div>
            <div class="one-fourth gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
                <article class="post first">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/5.jpg" alt="img"></a>
                    </div>
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">This pays especially well in technology, where you earn a premium for working fast.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">Here is a brief sketch of the economic proposition.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">Startups are not magic.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">Like all back-of-the-envelope calculations, this one has a lot of wiggle room.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">Imagine the stress of working for the Post Office for fifty years.</a></h3>
                </article><!--  /.post -->
            </div>
            <div class="one-fourth gn-animation" data-animation="fadeInUp" data-animation-delay="0.2s" data-animation-offset="75%">
                <article class="post first">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/5-2.jpg" alt="img"></a>
                    </div>
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">Lots of people get rich knowing nothing more than that.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">If you're a good hacker in your mid twenties, you can get a job paying about $80,000 per year.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">They don't change the laws of wealth creation.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">I wouldn't try to defend the actual numbers. But I stand by the structure of the calculation.</a></h3>
                </article><!--  /.post -->
            </div>
            <div class="one-fourth gn-animation" data-animation="fadeInUp" data-animation-delay="0.4s" data-animation-offset="75%">
                <article class="post first">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/5-3.jpg" alt="img"></a>
                    </div>
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">I think your best bet would be to start or join a startup.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">You could probably work twice as many hours as a corporate employee.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">Imagine the stress of working for the Post Office for fifty years. In a startup you compress all this stress into three or four years.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">This pays especially well in technology, where you earn a premium for working fast.</a></h3>
                </article><!--  /.post -->
            </div>
            <div class="one-fourth last gn-animation" data-animation="fadeInUp" data-animation-delay="0.6s" data-animation-offset="75%">
                <article class="post first">
                    <div class="thumb">
                        <a href="#"><img src="images/thumbs/5-4.jpg" alt="img"></a>
                    </div>
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">That's been a reliable way to get rich for hundreds of years.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">Like all back-of-the-envelope calculations, this one has a lot of wiggle room.</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">Three million? How do I get to be a billionaire, like Bill Gates?</a></h3>
                </article><!--  /.post -->
                <article class="post">
                    <span class="date">October 6, 2013</span>
                    <h3><a href="#">If $3 million a year seems high to some people, it will seem low to others.</a></h3>
                </article><!--  /.post -->
            </div>
        </div><!-- /.trending-posts -->
        <div class="gn-line"></div>
    </div><!-- /.col-md-12 -->
    <div class="col-md-8">
        <div class="social-media-posts gn-animation" data-animation="fadeInUp" data-animation-delay="0" data-animation-offset="75%">
            <div class="section-title">
                <h4><a href="#">Social Media</a></h4>
            </div>
            <article class="post">
                <div class="thumb">
                    <a href="#"><img src="images/thumbs/6.jpg" alt="img"></a>
                </div>
                <div class="content">
                    <div class="cat">
                        <a href="#">Mustreads</a>
                    </div>
                    <h3><a href="#">If you wanted to get rich.</a></h3>
                    <p class="excerpt-entry">I think your best bet would be to start or join a startup. That's been a reliable way to get rich for hundreds of years.</p>
                    <div class="activity">
                        <span class="views">345</span><span class="comment"><a href="#">15</a></span>
                    </div>
                </div>
            </article><!--  /.post -->
            <article class="post">
                <div class="thumb">
                    <a href="#"><img src="images/thumbs/6-2.jpg" alt="img"></a>
                </div>
                <div class="content">
                    <div class="cat">
                        <a href="#">Mustreads</a>
                    </div>
                    <h3><a href="#">Startups are not magic.</a></h3>
                    <p class="excerpt-entry">That's been a reliable way to get rich for hundreds of years.The word "startup" dates from the 1960s, but what happens in one is very similar.</p>
                    <div class="activity">
                        <span class="views">345</span><span class="comment"><a href="#">15</a></span>
                    </div>
                </div>
            </article><!--  /.post -->
            <article class="post">
                <div class="thumb">
                    <a href="#"><img src="images/thumbs/6-3.jpg" alt="img"></a>
                </div>
                <div class="content">
                    <div class="cat">
                        <a href="#">Mustreads</a>
                    </div>
                    <h3><a href="#">They don't change the laws of wealth creation.</a></h3>
                    <p class="excerpt-entry">That's been a reliable way to get rich for hundreds of years.The word "startup" dates from the 1960s.</p>
                    <div class="activity">
                        <span class="views">345</span><span class="comment"><a href="#">15</a></span>
                    </div>
                </div>
            </article><!--  /.post -->
            <article class="post">
                <div class="thumb">
                    <a href="#"><img src="images/thumbs/6-4.jpg" alt="img"></a>
                </div>
                <div class="content">
                    <div class="cat">
                        <a href="#">Mustreads</a>
                    </div>
                    <h3><a href="#">They just represent a point at the far end of the curve.</a></h3>
                    <p class="excerpt-entry">That's been a reliable way to get rich for hundreds of years.The word "startup" dates from the 1960s.</p>
                    <div class="activity">
                        <span class="views">345</span><span class="comment"><a href="#">15</a></span>
                    </div>
                </div>
            </article><!--  /.post -->
        </div><!-- /.social-media-posts -->
    </div><!-- /.col-md-8 -->
</div><!-- /.row -->   
@endsection

@section('css')

@endsection

@section('js')

@endsection