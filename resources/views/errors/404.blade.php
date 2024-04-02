@extends('errors::minimal')

@section('title', __('Página não encontrada'))

@section('content-error')
    <section class="section error-page">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-sm-12 col-md-offset-3 col-sm-offset-0">
                    <div class="error-wrap">
                        <h2>Desculpe, página não encontrada</h2>
                        <form action="#" id="searchform" method="get">
                            <input type="text" id="s" placeholder="Pesquisar no site">
                            <input type="submit" value="Search" id="searchsubmit">
                        </form>
                        <div class="spacer"></div>
                        <div class="go-home">
                            <a href="{{route('web.home')}}" class="gn-button" title="Voltar para Home">Voltar para Home</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
