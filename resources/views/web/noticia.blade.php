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
                        <span class="time"> {{$post['data']}}.</span>
                    </div>
                </div>
                <div class="body-post">
                    
                    <div class="main-post">
                        <div class="entry-post">
                            <img src="{{$post['img']}}" alt="image">
                            <p>{!!$post['content']!!}</p>
                        </div>
                           
                        <div class="relate-posts">
                            <div class="section-title">
                                <h4><a href="javascript:void(0)">Leia Também</a></h4>
                            </div>
                            <div class="post-wrap">
                                @if (!empty($pageMais) && count($pageMais) > 0)
                                    @foreach($pageMais as $postmais)
                                        <article class="post" style="min-height: 200px;">
                                            <div class="thumb">
                                                @php                                                     
                                                    if($cidade == 'caraguatatuba'){
                                                        $link = explode('/', $postmais['url']); 
                                                        $link = $link[3].'/'.$link[4].'/'.$link[5].'/'.$link[6];
                                                        $link = env('APP_URL').'/noticia/caraguatatuba/'.$link;
                                                    }elseif($cidade == 'ubatuba'){
                                                        $link = explode('/', $postmais['url']); 
                                                        $link = $link[3].'/'.$link[4].'/'.$link[5];
                                                        $link = env('APP_URL').'/noticia/ubatuba/'.$link;
                                                    }                                                   
                                                @endphp                                                
                                                <a href="{{$link}}"><img src="{{$postmais['img']}}" alt="{{$postmais['titulo']}}"></a>
                                            </div>
                                            <div class="content">
                                                <h3><a href="{{$link}}">{{$postmais['titulo']}}</a></h3>
                                                <p class="excerpt-entry">{{$postmais['content']}}</p>
                                                <div class="post-meta">
                                                    <span class="time">{{$postmais['data'] ?? ''}}</span>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            </article>
        </div>
    </div>
</div>
@endsection

@section('css')
    <style>
        table {
            border: 1px solid #ccc;
            border-collapse: collapse;
            margin: 0;
            padding: 0;
            width: 100%;
            table-layout: fixed;
        }
        table caption {
        font-size: 1.5em;
        margin: .5em 0 .75em;
        }

        table tr {
        background-color: #f8f8f8;
        border: 1px solid #ddd;
        padding: .35em;
        }

        table th,
        table td {
        padding: .625em;
        text-align: center;
        }

        table th {
        font-size: .85em;
        letter-spacing: .1em;
        text-transform: uppercase;
        }

        @media screen and (max-width: 600px) {
        table {
            border: 0;
        }

        table caption {
            font-size: 1.3em;
        }
        
        table thead {
            border: none;
            clip: rect(0 0 0 0);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            position: absolute;
            width: 1px;
        }
        
        table tr {
            border-bottom: 3px solid #ddd;
            display: block;
            margin-bottom: .625em;
        }
        
        table td {
            border-bottom: 1px solid #ddd;
            display: block;
            font-size: .8em;
            text-align: right;
        }
        
        table td::before {
            /*
            * aria-label has no advantage, it won't be read inside a table
            content: attr(aria-label);
            */
            content: attr(data-label);
            float: left;
            font-weight: bold;
            text-transform: uppercase;
        }
        
        table td:last-child {
            border-bottom: 0;
        }
        }
    </style>
@endsection