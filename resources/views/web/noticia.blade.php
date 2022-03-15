@extends('web.master.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="posts">
            <article class="post">
                <div class="head-post">
                    <h2>{{$post['titulo']}}</h2>
                    <div class="meta">
                        <span class="author">Fonte: <a target="_blank" href="{{$post['fontelink']}}">{{$post['fonte']}}</a></span>
                        <span class="time"> Publicado em {{$post['data']}}.</span>
                    </div>
                </div>
                <div class="body-post">
                    
                    <div class="main-post">
                        <div class="entry-post">
                            <img src="{{$post['img']}}" alt="image">
                            <p>{{$post['content']}}</p>
                        </div>
                           
                        <div class="relate-posts">
                            <div class="section-title">
                                <h4><a href="#">Read These Next</a></h4>
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
                                </article>
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
                                </article>
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
                                </article>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
@endsection