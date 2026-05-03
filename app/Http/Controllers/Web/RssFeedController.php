<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\{
    Company,
    Post
};
use Carbon\Carbon;

class RssFeedController extends Controller
{
    public function feed()
    {
        $postsHoje = Post::whereDate('created_at', Carbon::today())
            ->whereIn('type', ['artigo', 'noticia'])
            ->postson()
            ->limit(20)
            ->get();

        $paginas = Post::orderBy('created_at', 'DESC')
            ->where('type', 'pagina')
            ->postson()
            ->limit(10)
            ->get();

        $empresas = Company::orderBy('views', 'DESC')
            ->orderBy('client', 'DESC')
            ->available()
            ->limit(50)
            ->get();

        return response()->view('web.feed', [
            'artigos'  => $postsHoje->where('type', 'artigo'),
            'noticias' => $postsHoje->where('type', 'noticia'),
            'paginas'  => $paginas,
            'empresas' => $empresas,
        ])->header('Content-Type', 'application/xml');
    }
}
