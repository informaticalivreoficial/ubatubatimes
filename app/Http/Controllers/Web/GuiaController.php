<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CatCompany;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Support\Seo;
use App\Models\Config;

class GuiaController extends Controller
{
    protected $seo, $config;

    public function __construct()
    {
        $this->seo = new Seo();
        $this->config = Config::where('id', 1)->first();
    }

    public function guiaUbatuba()
    {
        $catEmpresas = CatCompany::query()
            ->with(['companies' => function ($q) {
        $q->available()
        ->select([
            'id',
            'alias_name',
            'slug',
            'logo',
            'content',
            'category_id'
        ])
        ->inRandomOrder(); // 🔥 só random
    }])
            ->whereNull('id_pai')
            ->active()
            ->orderByRaw('LOWER(title)') // 🔥 garante ordem consistente
            ->get();

        $head = $this->seo->render(
            'Guia de Ubatuba - ' . ($this->config->app_name ?? ''),
            $this->config->information ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.guiaUbatuba'),
            url(asset('frontend/assets/images/site-guia.png'))
        );

        return view('web.guia.index', [
            'head' => $head,
            'catEmpresas' => $catEmpresas,
        ]);
    }

    public function guiaEmpresa($slug)
    {
        $empresa = Company::query()
            ->with([
                'categoriaObject:id,slug,title',
                'subcategoriaObject:id,slug,title',
                'images' // 🔥 resolve N+1
            ])
            ->where('slug', $slug)
            ->available()
            ->firstOrFail();

        // 🔹 Empresas relacionadas — clientes (anunciantes) sempre primeiro,
        // e dentro de cada grupo (cliente / não-cliente) a ordem é aleatória.
        // orderByDesc() + inRandomOrder() não se combinam no Eloquent: o
        // inRandomOrder() sobrescreve qualquer ORDER BY anterior. Por isso
        // buscamos os dois grupos separadamente e juntamos depois.
        $clientes = Company::query()
            ->select(['id', 'alias_name', 'slug', 'logo', 'category_id', 'client'])
            ->where('id', '!=', $empresa->id)
            ->where('category_id', $empresa->category_id)
            ->where('client', true)
            ->available()
            ->inRandomOrder()
            ->limit(10)
            ->get();

        $restantes = Company::query()
            ->select(['id', 'alias_name', 'slug', 'logo', 'category_id', 'client'])
            ->where('id', '!=', $empresa->id)
            ->where('category_id', $empresa->category_id)
            ->where('client', false)
            ->available()
            ->inRandomOrder()
            ->limit(10 - $clientes->count())
            ->get();

        $empresasRelacionadas = $clientes->concat($restantes);

        // 🔹 Incrementa views (otimizado)
        $empresa->increment('views');

        $head = $this->seo->render(
            $empresa->alias_name ?? $this->config->app_name,
            strip_tags($empresa->content) ?: 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.guiaEmpresa', ['slug' => $empresa->slug]),
            $empresa->getMetaImg() ?? url(asset('frontend/assets/images/site-guia.png'))
        );

        return view('web.guia.empresa', [
            'head' => $head,
            'empresa' => $empresa,
            'empresas' => $empresasRelacionadas,
        ]);
    }

    public function guiaCategoria($slug)
    {
        $categoria = CatCompany::where('slug', $slug)->active()->first();

        // 🛡️ categoria não encontrada ou inativa: 404 em vez de erro 500
        abort_if(!$categoria, 404);

        $empresas = Company::query()
            ->with([
                'categoriaObject:id,slug,title',
                'images:id,company,path,cover'
            ])
            ->where('category_id', $categoria->id)
            ->available()
            ->orderByDesc('client')
            ->latest()
            ->paginate(30);

        $head = $this->seo->render(
            'Anúncios - ' . ($categoria->title ?? $this->config->app_name),
            strip_tags($categoria->content) ?: 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.guiaCategoria', ['slug' => $categoria->slug]),
            url(asset('frontend/assets/images/site-guia.png'))
        );

        return view('web.guia.categoria', [
            'head'      => $head,
            'categoria' => $categoria,
            'empresas'  => $empresas,
        ]);
    }

    public function guiaSubCategoria($slug)
    {
        $subcategoria = CatCompany::with('parent')
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $empresas = Company::with('categoriaObject')
            ->available()
            ->where('sub_category_id', $subcategoria->id)
            ->orderByDesc('views')
            ->paginate(30);

        $head = $this->seo->render(
            'Anúncios - ' . ($subcategoria->title ?? $this->config->app_name),
            strip_tags($subcategoria->content) ?: 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.guiaSubCategoria', $subcategoria->slug),
            asset('frontend/assets/images/site-guia.png')
        );

        return view('web.guia.subcategoria', [
            'head' => $head,
            'subcategoria' => $subcategoria,
            'empresas' => $empresas,
        ]);
    } 
}
