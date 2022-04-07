@extends('web.master.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="posts">
            <article class="post">
                <div class="head-post">
                    <h2>{{$post->titulo}}</h2>
                    <div class="meta">
                        <span class="time"> {{ Carbon\Carbon::parse($post->created_at)->format('d/m/Y') }}</span>
                    </div>
                </div>
                <div class="body-post">
                    
                    <div class="main-post">
                        <div class="entry-post">
                            <img src="{{$post->nocover()}}" alt="{{$post->titulo}}">
                            <p>{!!$post->content!!}</p>
                        </div>
                           
                        <div class="relate-posts">
                            <div class="section-title">
                                <h4><a href="javascript:void(0)">Leia Também</a></h4>
                            </div>
                            <div class="post-wrap">
                                @if (!empty($postsMais) && $postsMais->count() > 0)
                                    @foreach($postsMais as $postmais)
                                        <article class="post" style="min-height: 120px;">
                                            <div class="thumb">
                                                <a href="{{route('web.noticia', ['slug' => $postmais->slug])}}">
                                                    <img src="{{$postmais->cover()}}" alt="{{$postmais->titulo}}">
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h3><a href="{{route('web.noticia', ['slug' => $postmais->slug])}}">{{$postmais->titulo}}</a></h3>
                                                <p class="excerpt-entry">{!! $postmais->content_web !!}</p>
                                                <div class="post-meta">
                                                    <span class="time">{{ Carbon\Carbon::parse($postmais->created_at)->format('d/m/Y') }}</span>
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