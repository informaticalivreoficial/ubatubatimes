<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Mail\Web\ParceiroSend;
use App\Models\CatEmpresa;
use App\Models\Empresa;
use Illuminate\Http\Request;
use App\Services\ConfigService;
use App\Support\Seo;
use Illuminate\Support\Facades\Mail;

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
        $empresas = Empresa::orderBy('cliente', 'DESC')->inRandomOrder()->available()->get();

        $head = $this->seo->render('Guia de Ubatuba - ' . $this->configService->getConfig()->nomedosite ?? $this->configService->getConfig()->nomedosite,
            $this->configService->getConfig()->descricao ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.guiaUbatuba'),
            url(asset('frontend/assets/images/site-guia.png'))
        );

        return view('web.guia.index',[
            'head' => $head,
            'catEmpresas' => $catEmpresas,
            'empresas' => $empresas,
        ]);
    }

    public function guiaEmpresa($slug)
    {
        $empresa = Empresa::where('slug', $slug)->available()->first();
        $empresas = Empresa::orderBy('cliente', 'DESC')
                ->where('id', '!=', $empresa->id)
                ->where('categoria', $empresa->categoria)
                ->available()
                ->inRandomOrder()
                ->get();

        $empresa->views = $empresa->views + 1;
        $empresa->save();

        $head = $this->seo->render($empresa->alias_name ?? $this->configService->getConfig()->nomedosite,
            strip_tags($empresa->content) ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.guiaEmpresa', [ 'slug' => $empresa->slug ]),
            $empresa->getMetaImg() ?? url(asset('frontend/assets/images/site-guia.png'))
        );

        return view('web.guia.empresa',[
            'head' => $head,
            'empresa' => $empresa,
            'empresas' => $empresas,
        ]);
    }

    public function guiaCategoria($slug)
    {
        $categoria = CatEmpresa::where('slug', $slug)->available()->first();
        $empresas = Empresa::orderBy('cliente', 'DESC')
                ->where('cat_pai', $categoria->id)
                ->available()
                ->inRandomOrder()
                ->paginate(30);

        $head = $this->seo->render('Anúncios - ' . $categoria->titulo ?? $this->configService->getConfig()->nomedosite,
            strip_tags($categoria->content) ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.guiaCategoria', [ 'slug' => $categoria->slug ]),
            url(asset('frontend/assets/images/site-guia.png'))
        );
        
        return view('web.guia.categoria',[
            'head' => $head,
            'categoria' => $categoria,
            'empresas' => $empresas,
        ]);
    }

    public function guiaSubCategoria($slug)
    {
        $subcategoria = CatEmpresa::where('slug', $slug)->available()->first();
        $empresas = Empresa::orderBy('cliente', 'DESC')
                ->where('categoria', $subcategoria->id)
                ->available()
                ->inRandomOrder()
                ->paginate(30);

        $head = $this->seo->render('Anúncios - ' . $subcategoria->titulo ?? $this->configService->getConfig()->nomedosite,
            strip_tags($subcategoria->content) ?? 'Informática Livre desenvolvimento de sistemas web desde 2005',
            route('web.guiaCategoria', [ 'slug' => $subcategoria->slug ]),
            url(asset('frontend/assets/images/site-guia.png'))
        );
        
        return view('web.guia.subcategoria',[
            'head' => $head,
            'subcategoria' => $subcategoria,
            'empresas' => $empresas,
        ]);
    }

    public function sendEmailEmpresa(Request $request)
    {        
        $empresa = Empresa::where('id', $request->empresa_id)->first();
        if($request->nome == ''){
            $json = "Por favor preencha o campo <strong>Nome</strong>";
            return response()->json(['error' => $json]);
        }
        if(!filter_var($request->email, FILTER_VALIDATE_EMAIL)){
            $json = "O campo <strong>Email</strong> está vazio ou não tem um formato válido!";
            return response()->json(['error' => $json]);
        }
        if($request->mensagem == ''){
            $json = "Por favor preencha sua <strong>Mensagem</strong>";
            return response()->json(['error' => $json]);
        }
        if(!empty($request->bairro) || !empty($request->cidade)){
            $json = "<strong>ERRO</strong> Você está praticando SPAM!"; 
            return response()->json(['error' => $json]);
        }else{
            
            $data = [
                'sitename' => $this->configService->getConfig()->nomedosite,
                'siteemail' => env('MAIL_FROM_ADDRESS'),
                'reply_name' => $request->nome,
                'reply_email' => $request->email,
                'mensagem' => $request->mensagem,
                'config_site_name' => $this->configService->getConfig()->nomedosite,
            ];
            //dd($data);
            $empresa->email_send_count = $empresa->email_send_count + 1;
            $empresa->save();
            
            Mail::send(new ParceiroSend($data));
            
            $json = 'Obrigado '.getPrimeiroNome($request->nome).' sua mensagem foi enviada para <b>'.$empresa->alias_name.'</b> com sucesso!'; 
            return response()->json(['sucess' => $json]);
        }
    }
}
