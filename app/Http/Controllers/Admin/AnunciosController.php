<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Anuncio;
use App\Services\EmpresaService;
use App\Services\PlanService;
use Illuminate\Http\Request;

class AnunciosController extends Controller
{
    private $empresaService, $planService;

    public function __construct(EmpresaService $empresaService, PlanService $planService)
    {
        $this->empresaService = $empresaService;
        $this->planService = $planService;
    }
    public function index()
    {
        $anuncios = Anuncio::orderBy('created_at', 'DESC')->paginate(25);
        return view('admin.anuncios.index',[
            'anuncios' => $anuncios
        ]);
    }

    public function create()
    {
        return view('admin.anuncios.create',[
            'empresas' => $this->empresaService->listEmpresas(),
            'plans' => $this->planService->listPlans()
        ]);
    }
}
