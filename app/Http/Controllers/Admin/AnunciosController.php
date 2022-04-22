<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AnuncioRequest;
use App\Http\Requests\Admin\CatAnuncioRequest;
use App\Models\Anuncio;
use App\Models\CatAnuncio;
use App\Services\EmpresaService;
use App\Services\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;

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
        $categorias = CatAnuncio::whereNull('id_pai')
                    ->orderBy('titulo', 'ASC')
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
        return view('admin.anuncios.create',[
            'categorias' => $categorias,
            'empresas' => $this->empresaService->listEmpresas(),
            'plans' => $this->planService->listPlans()
        ]);
    }

    public function store(AnuncioRequest $request)
    {
        $data = $request->all();
        //unset($data['cat_pai']);
        $anuncioCreate = Anuncio::create($data);
        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return Redirect::back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if(!empty($request->file('300x250'))){
            $anuncioCreate['300x250'] = $request->file('300x250')->storeAs('anuncios', '300x250-'.Str::slug($request->titulo)  . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('300x250')->extension());
            $anuncioCreate->save();
        }
        
        return Redirect::route('anuncios.categorias.edit', $anuncioCreate->id)->with([
            'color' => 'success', 
            'message' => 'Anúncio cadastrado com sucesso!'
        ]);        
    }

    public function edit($id)
    {
        $anuncio = Anuncio::where('id', $id)->first();
        $categorias = CatAnuncio::whereNull('id_pai')
                    ->orderBy('titulo', 'ASC')
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
        
        return view('admin.anuncios.edit', [
            'anuncio' => $anuncio,
            'categorias' => $categorias,
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
            Cropper::flush($anuncio['300x250']);
            $anuncio['300x250'] = '';
        }

        if(!empty($request->file('728x90'))){
            Storage::delete($anuncio['728x90']);
            Cropper::flush($anuncio['728x90']);
            $anuncio['728x90'] = '';
        }

        $anuncio->fill($request->all());

        if(!empty($request->file('300x250'))){
            $anuncio['300x250'] = $request->file('300x250')->storeAs('anuncios', '300x250-'.Str::slug($request->titulo)  . '.' . $request->file('300x250')->extension());
        }

        if(!empty($request->file('728x90'))){
            $anuncio['728x90'] = $request->file('728x90')->storeAs('anuncios', '728x90-'.Str::slug($request->titulo)  . '.' . $request->file('728x90')->extension());
        }

        if(!$anuncio->save()){
            return redirect()->back()->withInput()->withErrors('Erro');
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

    public function categorias()
    {
        $categorias = CatAnuncio::whereNull('id_pai')
                    ->orderBy('titulo', 'ASC')
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(25);
        return view('admin.anuncios.categorias',[
            'categorias' => $categorias
        ]);
    }

    public function categoriasCreate(Request $request, $catpai)
    {        
        $catpai = CatAnuncio::where('id', $request->catpai)->first();
        
        return view('admin.anuncios.categorias-create',[
            'catpai' => $catpai
        ]);
    }

    public function fetchSubcategorias(Request $request)
    {        
        $data['values'] = CatAnuncio::where('id_pai', $request->cat_id)->get(["titulo", "id"]);        
        return response()->json($data);
    }

    public function categoriasStore(CatAnuncioRequest $request)
    {
        $criarCategoria = CatAnuncio::create($request->all());
        $criarCategoria->fill($request->all());

        $criarCategoria->setSlug();
        
        if($request->id_pai != null){
            return Redirect::route('anuncios.categorias.edit', [
                'id' => $criarCategoria->id,
            ])->with(['color' => 'success', 'message' => 'Sub Categoria cadastrada com sucesso!']);
        }else{
            return Redirect::route('anuncios.categorias.edit', [
                'id' => $criarCategoria->id,
            ])->with(['color' => 'success', 'message' => 'Categoria cadastrada com sucesso!']);
        }
    }

    public function categoriasEdit($id)
    {
        $categoria = CatAnuncio::where('id', $id)->first();
        if($categoria->id_pai != 'null'){
            $catpai = CatAnuncio::where('id', $categoria->id_pai)->first();
        }else{
            $catpai = 'null';
        }
        return view('admin.anuncios.categorias-edit', [
            'categoria' => $categoria,
            'catpai' => $catpai
        ]);
    }

    public function categoriasUpdate(CatAnuncioRequest $request, $id)
    {
        $categoria = CatAnuncio::where('id', $id)->first();
        $categoria->fill($request->all());

        $categoria->save();
        $categoria->setSlug();
        
        if($categoria->id_pai != null){
            return Redirect::route('anuncios.categorias.edit', [
                'id' => $categoria->id,
            ])->with(['color' => 'success', 'message' => 'Sub Categoria atualizada com sucesso!']);
        }else{
            return Redirect::route('anuncios.categorias.edit', [
                'id' => $categoria->id,
            ])->with(['color' => 'success', 'message' => 'Categoria atualizada com sucesso!']);
        }
        
    }

    public function delete(Request $request)
    {
        $categoria = CatAnuncio::where('id', $request->id)->first();
        $subcategoria = CatAnuncio::where('id_pai', $request->id)->first();
        $anuncio = Anuncio::where('categoria', $request->id)->first();
        $nome = getPrimeiroNome(Auth::user()->name);

        if(!empty($categoria) && empty($subcategoria)){
            if($categoria->id_pai == null){
                $json = "<b>$nome</b> você tem certeza que deseja excluir esta categoria?";
                return response()->json(['erroron' => $json,'id' => $categoria->id]);
            }else{
                // se tiver posts
                if(!empty($anuncio)){
                    $json = "<b>$nome</b> você tem certeza que deseja excluir esta sub categoria? Ela possui anúncios e tudo será excluído!";
                    return response()->json(['erroron' => $json,'id' => $categoria->id]);
                }else{
                    $json = "<b>$nome</b> você tem certeza que deseja excluir esta sub categoria?";
                    return response()->json(['erroron' => $json,'id' => $categoria->id]);
                }                
            }            
        }
        if(!empty($categoria) && !empty($subcategoria)){
            $json = "<b>$nome</b> esta categoria possui sub categorias! É peciso excluílas primeiro!";
            return response()->json(['error' => $json,'id' => $categoria->id]);
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }        
    }

    // public function deleteon(Request $request)
    // {
    //     $categoria = CatAnuncio::where('id', $request->categoria_id)->first();  
    //     $anuncio = Anuncio::where('categoria', $request->id)->first();
        
    //     $categoriaR = $categoria->titulo;

    //     if(!empty($categoria)){
    //         if(!empty($anuncio)){
    //             $anunciogb = PortifolioGb::where('portifolio', $anuncio->id)->first();
    //             if(!empty($produtogb)){
    //                 Storage::delete($anuncioliogb->path);
    //                 Cropper::flush($anuncioliogb->path);
    //                 $produtogb->delete();
    //             }
                
    //             Storage::deleteDirectory('portifolio/'.$anuncio->id);
    //             $categoria->delete();
    //         }
    //         $categoria->delete();
    //     }

    //     if($categoria->id_pai != null){
    //         return Redirect::route('catportifolio.index')->with([
    //             'color' => 'success', 
    //             'message' => 'A sub categoria '.$categoriaR.' foi removida com sucesso!'
    //         ]);
    //     }else{
    //         return Redirect::route('catportifolio.index')->with([
    //             'color' => 'success', 
    //             'message' => 'A categoria '.$categoriaR.' foi removida com sucesso!'
    //         ]);
    //     }        
    // }
}
