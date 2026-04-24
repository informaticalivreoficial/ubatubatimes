<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Support\Seo;
use App\Models\Config;
use App\Services\OndasService;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    protected $seo, $config;

    public function __construct()
    {
        $this->seo = new Seo();
        $this->config = Config::where('id', 1)->first();
    }

    public function home()
    {        
        $noticiasUbatuba = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'noticia')
                    ->where('category', 15)
                    ->postson()
                    ->limit(2)
                    ->get();
        $noticiasUbatuba1 = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'noticia')
                    ->where('category', 15)
                    ->postson()
                    ->offset(2)
                    ->limit(2)
                    ->get();
        $artigosDestaque = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'artigo')
                    ->where('category', 9)
                    ->postson()
                    ->limit(1)
                    ->get();
        $estradas = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'noticia')
                    ->where('category', 22)
                    ->postson()
                    ->first();
        $noticiasCaragua = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'noticia')
                    ->where('category', 16)
                    ->postson()
                    ->limit(4)
                    ->get();
        $noticiasSaoSebastiao = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'noticia')
                    ->where('category', 17)
                    ->postson()
                    ->limit(4)
                    ->get();
        $noticiasIlhabela = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'noticia')
                    ->where('category', 18)
                    ->postson()
                    ->limit(4)
                    ->get();
        $artigos = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'artigo')
                    ->where('category', '!=', 9)
                    ->where('category', '!=', 7)
                    ->postson()
                    ->limit(4)
                    ->get();
        $praiasDeUbatuba = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'artigo')
                    ->where('category', 9)
                    ->postson()
                    ->limit(5)
                    ->get();
        $gastronomiaDeUbatuba = Post::orderBy('created_at', 'DESC')
                    ->where('type', 'artigo')
                    ->where('category', 7)
                    ->postson()
                    ->limit(4)
                    ->get();
        
        // $positionSidebarhome = Anuncio::where('plan_id', 2)->available()->limit(3)->get();
        // $positionMainhome = Anuncio::where('plan_id', 9)->available()->limit(1)->get();
        // $positionFooterhome = Anuncio::where('plan_id', 5)->available()->limit(1)->get();

        //Boletim das Ondas
        //$boletim = new BoletimOndas('http://servicos.cptec.inpe.br/XML/cidade/5515/dia/0/ondas.xml');

        $head = $this->seo->render($this->config->app_name ?? env('APP_NAME'),
            $this->config->information ?? env('APP_NAME'),
            route('web.home'),
            $this->config->getmetaimg() ?? url(asset('theme/images/image.jpg'))
        );
        
    	return view('web.home',[
            'head' => $head,
            'noticiasUbatuba'  => $noticiasUbatuba,
            'noticiasUbatuba1'  => $noticiasUbatuba1,
            'artigosDestaque' => $artigosDestaque,
            'estradas' => $estradas,
            'noticiasCaragua' => $noticiasCaragua,
            'noticiasSaoSebastiao' => $noticiasSaoSebastiao,
            'noticiasIlhabela' => $noticiasIlhabela,
            //'boletim' => $boletim,
            //'artigos' => $artigos,
            'praiasDeUbatuba' => $praiasDeUbatuba,
            'gastronomiaDeUbatuba' => $gastronomiaDeUbatuba,
            //'positionSidebarhome' => $positionSidebarhome,
            //'positionMainhome' => $positionMainhome,
            //'positionFooterhome' => $positionFooterhome
		]);
    }

    public function ondas()
    {
        $wave = new OndasService();
        $dados = $wave->get();

        $resumo = [
            'manha' => !empty($dados['manha']) 
                ? $wave->resumo($dados['manha']) 
                : null,

            'tarde' => !empty($dados['tarde']) 
                ? $wave->resumo($dados['tarde']) 
                : null,
        ];
        //dd($dados);
        //Anúncio
        //$positionSidebarhome = Anuncio::where('plan_id', 8)->available()->limit(1)->get();

        $head = $this->seo->render('Boletim das Ondas para Ubatuba' ?? 'Informática Livre',
            'Boletim das Ondas para Ubatuba' ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.ondas'),
            url(asset('frontend/assets/images/ondas.png'))
        );

        return view('web.boletim-das-ondas',[
            'head' => $head,
            'dados' => $dados,
            'resumo' => $resumo,
            //'positionSidebarhome' => $positionSidebarhome,
        ]);
    }
}
