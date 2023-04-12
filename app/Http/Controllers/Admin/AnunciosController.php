<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnuncioRequest;
use App\Http\Requests\Admin\CatAnuncioRequest;
use App\Models\Anuncio;
use App\Models\CatAnuncio;
use App\Models\Fatura;
use App\Models\Plan;
use App\Services\EmpresaService;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

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
            'empresas' => $this->empresaService->ListAllEmpresas(),
            'plans' => $this->planService->listPlans()
        ]);
    }

    public function store(AnuncioRequest $request)
    {
        $data = $request->all();
        $anuncioCreate = Anuncio::create($data);
        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return Redirect::back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }
        if(!empty($request->file('300x250'))){
            $anuncioCreate['300x250'] = $request->file('300x250')->storeAs(env('AWS_PASTA') . 'anuncios', '300x250-'.Str::slug($request->titulo)  . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('300x250')->extension());
            $anuncioCreate->save();
        }

        //Cria Fatura
        if($request->gerarfatura === 'on'){
            $plano = Plan::where('id', $request->plan_id)->first();
            $dataFatura = [
                'anuncio' => $anuncioCreate->id,
                'empresa' => $anuncioCreate->empresa,
                'vencimento' => date('Y-m-d', strtotime("+{$request->vencimento} days")),
                'valor' => ($request->periodo == 1 ? $plano->valor_mensal : 
                           ($request->periodo == 3 ? $plano->valor_trimestral : 
                           ($request->periodo == 6 ? $plano->valor_semestral : 
                           ($request->periodo == 12 ? $plano->valor_anual : $plano->valor_mensal)))),
                'status' => 'pending'
            ];
            $criarFatura = Fatura::create($dataFatura);
            $criarFatura->save();
        }
        
        return Redirect::route('anuncios.edit', $anuncioCreate->id)->with([
            'color' => 'success', 
            'message' => 'Anúncio cadastrado com sucesso!'
        ]);        
    }

    public function edit($id)
    {
        $anuncio = Anuncio::where('id', $id)->first();        
        return view('admin.anuncios.edit', [
            'anuncio' => $anuncio,            
            'empresas' => $this->empresaService->listEmpresas(),
            'plans' => $this->planService->listPlans()
        ]);
    }

    public function update(AnuncioRequest $request, $id)
    {     
        $anuncio = Anuncio::where('id', $id)->first();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return Redirect::back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if(!empty($request->file('300x250'))){
            Storage::delete($anuncio['300x250']);
            $anuncio['300x250'] = '';
        }

        if(!empty($request->file('728x90'))){
            Storage::delete($anuncio['728x90']);
            $anuncio['728x90'] = '';
        }

        $anuncio->fill($request->all());

        if(!empty($request->file('300x250'))){
            $anuncio['300x250'] = $request->file('300x250')->storeAs(env('AWS_PASTA') . 'anuncios/' . $anuncio->id, '300x250-'.Str::slug($request->titulo)  . '.' . $request->file('300x250')->extension());
        }

        if(!empty($request->file('728x90'))){
            $anuncio['728x90'] = $request->file('728x90')->storeAs(env('AWS_PASTA') . 'anuncios/' . $anuncio->id, '728x90-'.Str::slug($request->titulo)  . '.' . $request->file('728x90')->extension());
        }

        if(!$anuncio->save()){
            return redirect()->back()->withInput()->withErrors('Erro');
        }

        //Cria Fatura
        if($request->gerarfatura === 'on'){
            $plano = Plan::where('id', $request->plan_id)->first();
            $dataFatura = [
                'anuncio' => $anuncio->id,
                'empresa' => $anuncio->empresa,
                'vencimento' => date('Y-m-d', strtotime("+{$request->vencimento} days")),
                'valor' => ($request->periodo == 1 ? $plano->valor_mensal : 
                           ($request->periodo == 3 ? $plano->valor_trimestral : 
                           ($request->periodo == 6 ? $plano->valor_semestral : 
                           ($request->periodo == 12 ? $plano->valor_anual : $plano->valor_mensal)))),
                'status' => 'pending'
            ];
            $criarFatura = Fatura::create($dataFatura);
            $criarFatura->save();
        }

        return Redirect::route('anuncios.edit', [
            'id' => $anuncio->id
        ])->with(['color' => 'success', 'message' => 'Anúncio atualizado com sucesso!']);
    }

    public function anuncioSetStatus(Request $request)
    {   
        $anuncio = Anuncio::find($request->id); 
        $anuncio->status = $request->status;
        $anuncio->save();
        return response()->json(['success' => true]); 
    }
    
}
