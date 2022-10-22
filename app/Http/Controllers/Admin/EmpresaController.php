<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CatEmpresaRequest;
use App\Http\Requests\Admin\Empresa as EmpresaRequest;
use App\Models\Anuncio;
use App\Models\CatEmpresa;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;
use Illuminate\Support\Str;
use App\Models\Cidades;
use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\EmpresaGb;
use App\Services\CidadeService;
use App\Services\EmpresaService;
use App\Services\EstadoService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EmpresaController extends Controller
{
    private $estadoService, $cidadeService, $empresaService;

    public function __construct(EstadoService $estadoService, CidadeService $cidadeService, EmpresaService $empresaService)
    {
        $this->estadoService = $estadoService;
        $this->cidadeService = $cidadeService;
        $this->empresaService = $empresaService;
    }

    public function index()
    {
        $empresas = $this->empresaService->listEmpresas(50);
        return view('admin.empresas.index', [
            'empresas' => $empresas,
        ]);
    }
    
    public function create()
    {
        $categorias = CatEmpresa::whereNull('id_pai')
                    ->orderBy('titulo', 'ASC')
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
        return view('admin.empresas.create', [
            'categorias' => $categorias,
            'estados' => $this->estadoService->getEstados(),
            'cidades' => $this->cidadeService->getCidades()
        ]);
    }
    
    public function store(EmpresaRequest $request)
    {
        $criarEmpresa = Empresa::create($request->all());
        $criarEmpresa->fill($request->all());

        if(!empty($request->file('logomarca'))){
            $criarEmpresa->logomarca = $request->file('logomarca')->storeAs(env('AWS_PASTA') . 'empresas/'. $criarEmpresa->uuid, 'logomarca-' . Str::slug($request->alias_name)  . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('logomarca')->extension());
            $criarEmpresa->save();
        }

        if(!empty($request->file('metaimg'))){
            $criarEmpresa->metaimg = $request->file('metaimg')->storeAs('empresas/'. $criarEmpresa->uuid, 'metaimg-' . Str::slug($request->alias_name)  . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('metaimg')->extension());
            $criarEmpresa->save();
        }

        //$criarEmpresa->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return Redirect::back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if ($request->allFiles() && empty($request->file('logomarca')) && empty($request->file('metaimg'))) {
            foreach ($request->allFiles()['files'] as $image) {
                $empresaImage = new EmpresaGb();
                $empresaImage->empresa = $criarEmpresa->id;
                $empresaImage->path = $image->storeAs(env('AWS_PASTA') . 'empresas/'. $criarEmpresa->uuid . '/' . $criarEmpresa->id, Str::slug($request->alias_name) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $empresaImage->save();
                unset($empresaImage);
            }
        }
        
        return redirect()->route('empresas.edit', [
            'id' => $criarEmpresa->id,
        ])->with(['color' => 'success', 'message' => 'Empresa cadastrada com sucesso!']);
    }
    
    public function edit($id)
    {
        $empresa = $this->empresaService->getEmpresaById($id);
        $anuncios = Anuncio::orderBy('created_at', 'DESC')->where('empresa', $empresa->id)->get();
        $categorias = CatEmpresa::whereNull('id_pai')
                    ->orderBy('titulo', 'ASC')
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->get();
        return view('admin.empresas.edit', [
            'empresa' => $empresa,
            'anuncios' => $anuncios,
            'categorias' => $categorias,
            'estados' => $this->estadoService->getEstados(),
            'cidades' => $this->cidadeService->getCidades()
        ]);
    }

    public function fetchCity(Request $request)
    {
        $data['cidades'] = Cidades::where("estado_id",$request->estado_id)->get(["cidade_nome", "cidade_id"]);
        return response()->json($data);
    }
   
    public function update(EmpresaRequest $request, $id)
    {
        $empresa = $this->empresaService->getEmpresaById($id);        

        if(!empty($request->file('logomarca'))){
            Storage::delete($empresa->logomarca);
            $empresa->logomarca = '';
        }

        if(!empty($request->file('metaimg'))){
            Storage::delete($empresa->metaimg);
            $empresa->metaimg = '';
        }

        $empresa->fill($request->all());

        if(!empty($request->file('logomarca'))){
            $empresa->logomarca = $request->file('logomarca')->storeAs(env('AWS_PASTA') . 'empresas/'. $empresa->uuid, 'logomarca-' . Str::slug($request->alias_name)  . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('logomarca')->extension());
            $empresa->save();
        }

        if(!empty($request->file('metaimg'))){
            $empresa->metaimg = $request->file('metaimg')->storeAs(env('AWS_PASTA') . 'empresas/'. $empresa->uuid, 'metaimg-' . Str::slug($request->alias_name)  . '-' . str_replace('.', '', microtime(true)) . '.' . $request->file('metaimg')->extension());
            $empresa->save();
        }

        $empresa->save();
        //$empresa->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return Redirect::back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if ($request->allFiles() && empty($request->file('logomarca')) && empty($request->file('metaimg'))) {
            foreach ($request->allFiles()['files'] as $image) {
                $empresaImage = new EmpresaGb();
                $empresaImage->empresa = $empresa->id;
                $empresaImage->path = $image->storeAs(env('AWS_PASTA') . 'empresas/'. $empresa->uuid . '/' . $empresa->id, Str::slug($request->alias_name) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $empresaImage->save();
                unset($empresaImage);
            }
        }

        return redirect()->route('empresas.edit', [
            'id' => $empresa->id,
        ])->with(['color' => 'success', 'message' => 'Empresa atualizada com sucesso!']);
    }

    public function empresaSetStatus(Request $request)
    {  
        $empresa = $this->empresaService->setStatus($request->id, $request->status);
        return response()->json($empresa);
    }

    public function delete(Request $request)
    {
        $empresa = $this->empresaService->getEmpresaById($request->id);
        $empresaGb = EmpresaGb::where('empresa', $empresa->id)->first();
        $nome = getPrimeiroNome(Auth::user()->name);

        if(!empty($empresa)){
            if(!empty($empresaGb) && $empresa->anuncios()->count() > 0){
                $json = "<b>$nome</b> você tem certeza que deseja excluir esta empresa? Existem imagens e Anúncios adicionados e tudo será excluído!";                
            }elseif(!empty($empresaGb) && $empresa->anuncios()->count() == 0){
                $json = "<b>$nome</b> você tem certeza que deseja excluir esta empresa? Existem imagens adicionadas e todas serão excluídas!";
            }else{
                $json = "<b>$nome</b> você tem certeza que deseja excluir esta empresa?";
            }      
            return response()->json(['error' => $json,'id' => $request->id]);      
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }     
    }

    public function deleteon(Request $request)
    {
        $empresa = $this->empresaService->getEmpresaById($request->empresa_id);
        $imageDelete = EmpresaGb::where('empresa', $empresa->id)->first();
        $anuncio = Anuncio::where('empresa', $empresa->id)->first();
        $postR = $empresa->alias_name;

        if(!empty($empresa)){
            Storage::delete($empresa->logomarca);
            Storage::delete($empresa->metaimg);
            // Cropper::flush($empresa->logomarca);            
            // Cropper::flush($empresa->metaimg);
            if(!empty($imageDelete)){
                Storage::delete($imageDelete->path);
               //Cropper::flush($imageDelete->path);
                $imageDelete->delete();
                Storage::deleteDirectory('empresas/' . $empresa->uuid . '/' . $empresa->id);
                Storage::deleteDirectory('empresas/' . $empresa->uuid);
            }
            if(!empty($anuncio)){
                Storage::delete($anuncio['300x250']);
                Storage::delete($anuncio['468x90']);
                Storage::delete($anuncio['336x280']);
                Storage::delete($anuncio['728x90']);
                // Cropper::flush($anuncio['300x250']);
                // Cropper::flush($anuncio['468x90']);
                // Cropper::flush($anuncio['336x280']);
                // Cropper::flush($anuncio['728x90']);
                Storage::deleteDirectory('anuncios/' . $anuncio->id);
                $anuncio->delete();
            }
            $empresa->delete();
        }

        return redirect()->route('empresas.index')->with([
            'color' => 'success', 
            'message' => 'Empresa '.$postR.' foi removida com sucesso!'
        ]);
    }

    public function imageSetCover(Request $request)
    {
        $imageSetCover = $this->empresaService->setCover($request->image);
        return response()->json($imageSetCover);
    }

    public function imageRemove(Request $request)
    {
        $imageDelete = $this->empresaService->imageRemoveGb($request->image);
        return response()->json($imageDelete);
    }

    public function categorias()
    {
        $categorias = CatEmpresa::whereNull('id_pai')
                    ->orderBy('titulo', 'ASC')
                    ->orderBy('status', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->paginate(25);
        return view('admin.empresas.categorias',[
            'categorias' => $categorias
        ]);
    }

    public function categoriasCreate(Request $request, $catpai)
    {        
        $catpai = CatEmpresa::where('id', $request->catpai)->first();
        
        return view('admin.empresas.categorias-create',[
            'catpai' => $catpai
        ]);
    }

    public function fetchSubcategorias(Request $request)
    {        
        $data['values'] = CatEmpresa::where('id_pai', $request->cat_id)->get(["titulo", "id"]);        
        return response()->json($data);
    }

    public function categoriasStore(CatEmpresaRequest $request)
    {
        $criarCategoria = CatEmpresa::create($request->all());
        $criarCategoria->fill($request->all());

        $criarCategoria->setSlug();
        
        if($request->id_pai != null){
            return Redirect::route('empresas.categorias.edit', [
                'id' => $criarCategoria->id,
            ])->with(['color' => 'success', 'message' => 'Sub Categoria cadastrada com sucesso!']);
        }else{
            return Redirect::route('empresas.categorias.edit', [
                'id' => $criarCategoria->id,
            ])->with(['color' => 'success', 'message' => 'Categoria cadastrada com sucesso!']);
        }
    }

    public function categoriasEdit($id)
    {
        $categoria = CatEmpresa::where('id', $id)->first();
        if($categoria->id_pai != 'null'){
            $catpai = CatEmpresa::where('id', $categoria->id_pai)->first();
        }else{
            $catpai = 'null';
        }
        return view('admin.empresas.categorias-edit', [
            'categoria' => $categoria,
            'catpai' => $catpai
        ]);
    }

    public function categoriasUpdate(CatEmpresaRequest $request, $id)
    {
        $categoria = CatEmpresa::where('id', $id)->first();
        $categoria->fill($request->all());

        $categoria->save();
        $categoria->setSlug();
        
        if($categoria->id_pai != null){
            return Redirect::route('empresas.categorias.edit', [
                'id' => $categoria->id,
            ])->with(['color' => 'success', 'message' => 'Sub Categoria atualizada com sucesso!']);
        }else{
            return Redirect::route('empresas.categorias.edit', [
                'id' => $categoria->id,
            ])->with(['color' => 'success', 'message' => 'Categoria atualizada com sucesso!']);
        }
        
    }

    public function categoriasDelete(Request $request)
    {
        $categoria = CatEmpresa::where('id', $request->id)->first();
        $subcategoria = CatEmpresa::where('id_pai', $request->id)->first();
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

    
}
