<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\CatEmpresa;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Services\ConfigService;
use App\Support\Seo;

class GuiaController extends Controller
{
    protected $configService;
    protected $seo;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
        $this->seo = new Seo();
    }

    public function guiaUbatuba()
    {
        $catEmpresas = CatEmpresa::orderBy('titulo', 'ASC')->available()->whereNull('id_pai')->get();
        $empresas = Empresa::orderBy('created_at', 'DESC')->available()->get();
        return view('web.guia.index',[
            'catEmpresas' => $catEmpresas,
            'empresas' => $empresas,
        ]);
    }

    public function guiaEmpresa($slug)
    {
        $empresa = Empresa::where('slug', $slug)->available()->first();
        $empresas = Empresa::orderBy('created_at', 'DESC')
                ->where('id', '!=', $empresa->id)
                ->where('categoria', $empresa->categoria)
                ->available()
                ->inRandomOrder()
                ->get();

        $empresa->views = $empresa->views + 1;
        $empresa->save();

        $head = $this->seo->render($empresa->alias_name ?? 'Informática Livre',
            strip_tags($empresa->content) ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.home'),
            $empresa->getMetaImg() ?? $this->configService->getMetaImg() ?? 'https://informaticalivre.com/media/metaimg.jpg'
        );

        return view('web.guia.empresa',[
            'head' => $head,
            'empresa' => $empresa,
            'empresas' => $empresas,
        ]);
    }
}
