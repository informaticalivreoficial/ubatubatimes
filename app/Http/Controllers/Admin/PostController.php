<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Admin\Post as PostRequest;
use App\Models\User;
use App\Models\Post;
use App\Models\PostGb;
use App\Models\CatPost;
use App\Notifications\PostCreatedUpdated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Goutte\Client;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\DB;
use Vedmant\FeedReader\Facades\FeedReader;
use GuzzleHttp\Client as GuzzleClient;
use Symfony\Component\HttpClient\HttpClient;

class PostController extends Controller
{
    protected $crowler;
    
    public function __construct()
    {
        $client = HttpClient::create([
            'timeout' => 30,
            'headers' => [
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
            ],
        ]);

        $this->crowler = new Client($client);
    }

    public function index(Request $request)
    {
        if($request->segments()[2] == 'artigos'){
            $tipo = 'artigo';
            $linkView = 'blog.artigo';
            $tituloPagina = 'Artigos';
        }elseif($request->segments()[2] == 'noticias'){
            $tipo = 'noticia';
            $linkView = 'noticia';
            $tituloPagina = 'Notícias';
        }elseif($request->segments()[2] == 'paginas'){
            $tipo = 'pagina';
            $linkView = 'pagina';
            $tituloPagina = 'Páginas';
        }

        $posts = Post::where('tipo', $tipo)->orderBy('status', 'ASC')->orderBy('created_at', 'DESC')->paginate(25);
        
        return view('admin.posts.index', [
            'posts' => $posts,
            'tituloPagina' => $tituloPagina,
            'linkView' => $linkView
        ]);
    }  
    
    public function crowlerNoticiasUbatuba()
    {
        $urlUbatuba  = 'https://www.ubatuba.sp.gov.br/noticias/';
        $pageUbatuba = $this->crowler->request('GET', $urlUbatuba);
        $pageUbatuba->filter('.blog-items li')->each( function ($item){
            $resultsUbatuba[] = [
                'tipo' => 'noticia',
                'autor' => 1,
                'titulo' => $item->filter('h4')->text(),
                'slug' => Str::slug($item->filter('h4')->text()),
                'cat_pai' => 14,
                'categoria' => 15,
                'status' => 1,
                'thumb_legenda' => 'Foto: Divulgação Prefeitura Municipal de Ubatuba',
                'url' => $item->filter('a')->attr('href'),
                'created_at' => now(),
            ]; 
            
            $posts = Post::where('tipo', 'noticia')->where('titulo', $resultsUbatuba[0]['titulo'])->first();
            
            if($posts == null){
                $link = $resultsUbatuba[0]['url'];
                $linkContent = $this->crowler->request('GET', $link);            
                $resultsUbatuba[0]['content'] = $linkContent->filter('.article-body-wrap .body-text')->html() . '<br>Fonte: <a target="_blank" href="https://www.ubatuba.sp.gov.br">Divulgação Prefeitura Municipal de Ubatuba</a>';
                $resultsUbatuba[0]['img'] = $linkContent->filter('.page-content figure img')->attr('src');

                $imgurl = $resultsUbatuba[0]['img'];
                $contents = file_get_contents($imgurl);
                $name = substr($imgurl, strrpos($imgurl, '/') + 1);
                
                unset($resultsUbatuba[0]['img']);
                unset($resultsUbatuba[0]['url']);
                $criarPost = DB::table('posts')->updateOrInsert($resultsUbatuba[0]);
                $id = DB::getPdo()->lastInsertId();
                Storage::disk()->put(env('AWS_PASTA') . 'noticias/' . $id . '/' . $name, $contents);
                
                $postGb = new PostGb();
                $postGb->post = $id;
                $postGb->path = env('AWS_PASTA') . 'noticias/' . $id . '/' . $name;
                $postGb->save();
                unset($postGb);

                //$post = Post::find($id);
                //$autor = User::find($post->autor);
                //$autor->notify(new PostCreatedUpdated($post));                
            }
        });               
    }

    public function crowlerFundartUbatuba()
    {
        $urlFundartUbatuba  = 'https://fundart.com.br/noticias';
        $pageFundartUbatuba = $this->crowler->request('GET', $urlFundartUbatuba); 
                
            $resultFundartUbatuba = [                 
                'tipo' => 'noticia',
                'autor' => 1,
                'titulo' => $pageFundartUbatuba->filter('.archive-posts .row h2')->text(),
                'slug' => Str::slug($pageFundartUbatuba->filter('.archive-posts .row h2')->text()),
                'cat_pai' => 14,
                'categoria' => 15,
                'status' => 1,
                'thumb_legenda' => 'Foto: Divulgação Fundação de Arte e Cultura de Ubatuba – FundArt',
                'url' => $pageFundartUbatuba->filter('.archive-posts .row a')->attr('href'),
                'created_at' => now(),
                'publish_at' => now(),
            ]; 
            
            $post = Post::where('tipo', 'noticia')->where('titulo', $resultFundartUbatuba['titulo'])->first();

            // $imgContent = $this->crowler->request('GET', $resultFundartUbatuba['url']); 
            // $imgurl = $imgContent->filter('.single-content img')->attr('src');
            // $contents = file_get_contents($imgurl);
            // $name = substr($imgurl, strrpos($imgurl, '/') + 1);

            //dd($imgurl);
            
            if($post == null){
                $linkContent = $this->crowler->request('GET', $resultFundartUbatuba['url']);            
                $resultFundartUbatuba['content'] = $linkContent->filter('.single-content p')->eq(2)->html() . '<br>Fonte: <a target="_blank" href="https://fundart.com.br">Divulgação Fundação de Arte e Cultura de Ubatuba – FundArt</a>';
                $resultFundartUbatuba['img'] = $linkContent->filter('.single-content img')->attr('src');
                
                //$imgurl = explode('300x300', $imgurl);                
                //$imgurl = $imgurl[0] . '768x769' . $imgurl[1];
                $contents = file_get_contents($resultFundartUbatuba['img']);
                $name = substr($resultFundartUbatuba['img'], strrpos($resultFundartUbatuba['img'], '/') + 1);
                
                unset($resultFundartUbatuba['img']);
                unset($resultFundartUbatuba['url']);
                $criarPost = DB::table('posts')->updateOrInsert($resultFundartUbatuba);
                $id = DB::getPdo()->lastInsertId();
                Storage::disk()->put(env('AWS_PASTA') . 'noticias/' . $id . '/' . $name, $contents);
                
                $postGb = new PostGb();
                $postGb->post = $id;
                $postGb->path = env('AWS_PASTA') . 'noticias/' . $id . '/' . $name;
                $postGb->save();
                unset($postGb);

                //$post = Post::find($id);
                //$autor = User::find($post->autor);
                //$autor->notify(new PostCreatedUpdated($post));
            }    
    }

    public function crowlerNoticiasCaraguatatuba()
    {
        $urlCaragua  = 'https://www.caraguatatuba.sp.gov.br/pmc/';
        $pageCaragua = $this->crowler->request('GET', $urlCaragua);
        $result = [
            'tipo' => 'noticia',
            'autor' => 1,
            'titulo' => $pageCaragua->filter('.card-deck .card h5')->eq(0)->text(),
            'slug' => Str::slug($pageCaragua->filter('.card-deck .card h5')->eq(0)->text()),
            'cat_pai' => 14,
            'categoria' => 16,
            'status' => 1,
            'thumb_legenda' => 'Foto: Divulgação Prefeitura Municipal de Caraguatatuba',
            'created_at' => now(),
            'publish_at' => now(),
        ];
        
        $posts = Post::where('tipo', 'noticia')->where('titulo', $result['titulo'])->first();

        if($posts == null){     
            $link = $pageCaragua->filter('.card-deck .card a')->eq(0)->attr('href');
            $linkContent = $this->crowler->request('GET', $link);   
            $content = ['content' => $linkContent->filter('.card-text')->html() . '<br>Fonte: <a target="_blank" href="https://www.caraguatatuba.sp.gov.br/">Divulgação Prefeitura Municipal de Caraguatatuba</a>'];     
            $result = array_merge($result, $content);

            $imgurl = $linkContent->filter('.card-deck img')->attr('src');
            $contents = file_get_contents($imgurl);
            $name = substr($imgurl, strrpos($imgurl, '/') + 1);
            
            $criarPost = DB::table('posts')->updateOrInsert($result);
            $id = DB::getPdo()->lastInsertId();
            Storage::disk()->put(env('AWS_PASTA') . 'noticias/' . $id . '/' . $name, $contents);
                
            $postGb = new PostGb();
            $postGb->post = $id;
            $postGb->path = env('AWS_PASTA') . 'noticias/' . $id . '/' . $name;
            $postGb->save();
            unset($postGb);

            //$post = Post::find($id);
            //$autor = User::find($post->autor);
            //$autor->notify(new PostCreatedUpdated($post));
        }
    }

    public function crowlerNoticiasSaoSebastiao()
    {
        $urlSSB  = 'https://saosebastiao.sp.gov.br';
        $pageSSB = $this->crowler->request('GET', $urlSSB);
        
        $titulo = $pageSSB->filter('.post-list-content article .post-core h3')->eq(0)->text();
        
        $posts = Post::where('tipo', 'noticia')->where('titulo', $titulo)->first();

        sleep(3);

        if($posts == null){     
            $link = 'https://saosebastiao.sp.gov.br/' . $pageSSB->filter('.post-list-content article .post-core h3 a')->eq(0)->attr('href');            
            $linkContent = $this->crowler->request('GET', $link); 
            $imgurl = $link . '/' . $linkContent->filter('.c-slider .slide-list .slide')->eq(0)->attr('style');            
            $v = explode("url('", $imgurl);
            $v1 = explode("');", $v[1]);
            $v2 = 'https://saosebastiao.sp.gov.br/' . $v1[0];            
            $contents = file_get_contents($v2);
            $name = substr($v2, strrpos($v2, '/') + 1);

            $data = [
                'tipo' => 'noticia',
                'autor' => 1,
                'titulo' => $pageSSB->filter('.post-list-content article .post-core h3')->eq(0)->text(),
                'slug' => Str::slug($pageSSB->filter('.post-list-content article .post-core h3')->eq(0)->text()),
                'content' => $linkContent->filter('.post .post-inner .post-core .post-content-inner')->html() . '<br>Fonte: <a target="_blank" href="http://www.saosebastiao.sp.gov.br/">Divulgação Prefeitura Municipal de São Sebastião</a>',
                'cat_pai' => 14,
                'categoria' => 17,
                'status' => 1,
                'thumb_legenda' => 'Foto: Divulgação Prefeitura Municipal de São Sebastião',
                'created_at' => now(),
                'publish_at' => now(),
            ];
            
            $criarPost = DB::table('posts')->updateOrInsert($data);
            $id = DB::getPdo()->lastInsertId();
            Storage::disk()->put(env('AWS_PASTA') . 'noticias/' . $id . '/' . $name, $contents);
                
            $postGb = new PostGb();
            $postGb->post = $id;
            $postGb->path = env('AWS_PASTA') . 'noticias/' . $id . '/' . $name;
            $postGb->save();
            unset($postGb);

            $post = Post::find($id);
            $autor = User::find($post->autor);
            $autor->notify(new PostCreatedUpdated($post));
        }
        
    }

    public function crowlerNoticiasIlhabela()
    {
        $urlIlhaBela  = 'https://www.ilhabela.sp.gov.br/portal/noticias';
        $pageIlhaBela = $this->crowler->request('GET', $urlIlhaBela);
        $result = [
            'tipo' => 'noticia',
            'autor' => 1,
            'titulo' => $pageIlhaBela->filter('.ntc_cont_noticias a .ntc_noticia .ntc_area_info_noticia .ntc_cont_info_noticia .ntc_titulo_noticia')->eq(0)->text(),
            'slug' => Str::slug($pageIlhaBela->filter('.ntc_cont_noticias a .ntc_noticia .ntc_area_info_noticia .ntc_cont_info_noticia .ntc_titulo_noticia')->eq(0)->text()),
            'cat_pai' => 14,
            'categoria' => 18,
            'status' => 1,
            'thumb_legenda' => 'Foto: Divulgação Prefeitura Municipal de Ilhabela',
            'created_at' => now(),
            'publish_at' => now(),
        ];
        
        $posts = Post::where('tipo', 'noticia')->where('titulo', $result['titulo'])->first();

        if($posts == null){     
            $link = 'https://www.ilhabela.sp.gov.br' . $pageIlhaBela->filter('.ntc_cont_noticias a')->eq(0)->attr('href');
            $linkContent = $this->crowler->request('GET', $link);   
            
            $content = ['content' => $linkContent->filter('.ntc_descricao_noticia .ntc_cont_descricao_noticia')->html() . '<br>Fonte: <a target="_blank" href="https://www.ilhabela.sp.gov.br/">Divulgação Prefeitura Municipal de Ilhabela</a>'];
            $result = array_merge($result, $content);
            
            $imgurl = 'https://www.ilhabela.sp.gov.br' . $linkContent->filter('.ntc_area_slide_imagens_noticia .ntc_img_slide_noticia img')->eq(0)->attr('src');
            
            $contents = file_get_contents($imgurl);
            $name = substr($imgurl, strrpos($imgurl, '/') + 1);
            
            $criarPost = DB::table('posts')->updateOrInsert($result);
            $id = DB::getPdo()->lastInsertId();
            Storage::disk()->put(env('AWS_PASTA') . 'noticias/' . $id . '/' . $name, $contents);
                
            $postGb = new PostGb();
            $postGb->post = $id;
            $postGb->path = env('AWS_PASTA') . 'noticias/' . $id . '/' . $name;
            $postGb->save();
            unset($postGb);

            //$post = Post::find($id);
            //$autor = User::find($post->autor);
            //$autor->notify(new PostCreatedUpdated($post));
        }         
    }

    public function create()
    {
        $categorias = CatPost::orderBy('titulo', 'ASC')->get();
        $users = User::where('admin', '=', '1')->orWhere('editor', '=', '1')->orWhere('superadmin', '=', '1')->get();
        return view('admin.posts.create',[
            'users' => $users,
            'categorias' => $categorias
        ]);
    }

    public function store(PostRequest $request)
    {        
        $data = $request->all();
        $catPai = CatPost::where('id', $request->categoria)->first();
        $data['cat_pai'] = $catPai->id_pai;

        $criarPost = Post::create($data);
        //$criarPost->fill($request->all());

        $secao = ($request->tipo == 'artigo' ? 'artigos' : 
                 ($request->tipo == 'noticia' ? 'noticias' : 
                 ($request->tipo == 'pagina' ? 'paginas' : 'posts')));

        $criarPost->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return Redirect::back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }
        
        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $postGb = new PostGb();
                $postGb->post = $criarPost->id;
                $postGb->path = $image->storeAs(env('AWS_PASTA') . $secao.'/' . $criarPost->id, Str::slug($request->titulo) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $postGb->save();
                unset($postGb);
            }
        }
        return Redirect::route('posts.edit', [
            'id' => $criarPost->id,
        ])->with(['color' => 'success', 'message' => $request->tipo.' cadastrado com sucesso!']);
    }

    public function edit($id)
    {
        $categorias = CatPost::orderBy('titulo', 'ASC')->where('id_pai', null)->get();
        $editarPost = Post::where('id', $id)->first();
        $users = User::where('admin', '=', '1')->orWhere('editor', '=', '1')->orWhere('superadmin', '=', '1')->get();

        if($editarPost->tipo == 'artigo'){
            $tipo = 'artigos';
            $tituloPagina = 'Artigo';
        }elseif($editarPost->tipo == 'noticia'){
            $tipo = 'noticias';
            $tituloPagina = 'Notícia';
        }elseif($editarPost->tipo == 'pagina'){
            $tipo = 'paginas';
            $tituloPagina = 'Página';
        }
        
        return view('admin.posts.edit', [
            'post' => $editarPost,
            'users' => $users,
            'categorias' => $categorias,
            'tituloPagina' => $tituloPagina,
            'tipo' => $tipo
        ]);
    }

    public function update(PostRequest $request, $id)
    {        
        $postUpdate = Post::where('id', $id)->first();
        $postUpdate->fill($request->all());

        $secao = ($request->tipo == 'artigo' ? 'artigos' : 
                 ($request->tipo == 'noticia' ? 'noticias' : 
                 ($request->tipo == 'pagina' ? 'paginas' : 'posts')));

        $postUpdate->save();
        $postUpdate->setSlug();

        $validator = Validator::make($request->only('files'), ['files.*' => 'image']);

        if ($validator->fails() === true) {
            return Redirect::back()->withInput()->with([
                'color' => 'orange',
                'message' => 'Todas as imagens devem ser do tipo jpg, jpeg ou png.',
            ]);
        }

        if ($request->allFiles()) {
            foreach ($request->allFiles()['files'] as $image) {
                $postImage = new PostGb();
                $postImage->post = $postUpdate->id;
                $postImage->path = $image->storeAs(env('AWS_PASTA') . $secao.'/' . $postUpdate->id, Str::slug($request->titulo) . '-' . str_replace('.', '', microtime(true)) . '.' . $image->extension());
                $postImage->save();
                unset($postImage);
            }
        }

        return Redirect::route('posts.edit', [
            'id' => $postUpdate->id,
        ])->with(['color' => 'success', 'message' => $request->tipo.' atualizado com sucesso!']);
    } 

    public function trash()
    {
        // if(Auth::user()->editor == 1){
        
        // }
        $postTrash = Post::orderBy('created_at', 'DESC')
                    ->orderBy('status', 'ASC')
                    ->onlyTrashed()
                    ->paginate(100);
        
        return view('admin.posts.trash', [
            'posts' => $postTrash
        ]);
    }

    public function postSetStatus(Request $request)
    {        
        $post = Post::find($request->id);
        $post->status = $request->status;
        $post->save();
        return response()->json(['success' => true]);
    }

    public function categoriaList(Request $request)
    {   
        $allData = [];
        $categorias = CatPost::where('tipo', '=', $request->categoria_tipo)->where('id_pai', null)->get();     
        foreach($categorias as $key => $categoria){
            $allData[$key]['catTitulo'] = $categoria->titulo;
            $allData[$key]['catId'] = $categoria->id;

            $subCat = [];
            if($categoria->children){
                foreach($categoria->children as $k => $subcategoria){
                    $subCat[$k]['id'] = $subcategoria->id; 
                    $subCat[$k]['titulo'] = $subcategoria->titulo;                                       
                }
            }
            $allData[$key]['subcategory'] = $subCat;
        }         
        return response()->json($allData);
    }

    public function imageRemove(Request $request)
    {
        $imageDelete = PostGb::where('id', $request->image)->first();
        Storage::delete($imageDelete->path);
        Cropper::flush($imageDelete->path);
        $imageDelete->delete();
        $json = [
            'success' => true,
        ];
        return response()->json($json);
    }

    public function imageSetCover(Request $request)
    {
        $imageSetCover = PostGb::where('id', $request->image)->first();
        $allImage = PostGb::where('post', $imageSetCover->post)->get();
        foreach ($allImage as $image) {
            $image->cover = null;
            $image->save();
        }
        $imageSetCover->cover = true;
        $imageSetCover->save();
        $json = [
            'success' => true,
        ];
        return response()->json($json);
    }

    public function delete(Request $request)
    {
        $postdelete = Post::where('id', $request->id)->first();
        $postGb = PostGb::where('post', $postdelete->id)->first();
        $nome = getPrimeiroNome(Auth::user()->name);

        $tipo = ($postdelete->tipo == 'artigo' ? 'este artigo' : 
                 ($postdelete->tipo == 'noticia' ? 'esta notícia' : 
                 ($postdelete->tipo == 'pagina' ? 'esta página' : 'este post')));

        if(!empty($postdelete)){
            if(!empty($postGb)){
                $json = "<b>$nome</b> você tem certeza que deseja excluir $tipo? Existem imagens adicionadas e todas serão excluídas!";
                return response()->json(['error' => $json,'id' => $postdelete->id]);
            }else{
                $json = "<b>$nome</b> você tem certeza que deseja excluir $tipo?";
                return response()->json(['error' => $json,'id' => $postdelete->id]);
            }            
        }else{
            return response()->json(['error' => 'Erro ao excluir']);
        }
    }
    
    public function deleteon(Request $request)
    {
        $postdelete = Post::where('id', $request->post_id)->first();  
        //$imageDelete = PostGb::where('post', $postdelete->id)->first();
        $postR = $postdelete->titulo;

        $secao = ($postdelete->tipo == 'artigo' ? 'artigos' : 
                 ($postdelete->tipo == 'noticia' ? 'noticias' : 
                 ($postdelete->tipo == 'pagina' ? 'paginas' : 'posts')));
        
        if(!empty($postdelete)){
            // if(!empty($imageDelete)){
            //     Storage::delete($imageDelete->path);
            //     Cropper::flush($imageDelete->path);
            //     $imageDelete->delete();
            //     Storage::deleteDirectory($secao.'/'.$postdelete->id);
            //     $postdelete->delete();
            // }
            $postdelete->delete();
        }
        return Redirect::route('posts.'.$secao.'')->with([
            'color' => 'success', 
            'message' => $postdelete->tipo.' '.$postR.' foi movido para a lixeira!'
        ]);
    }

    public function deleteCron()
    {
        $posts = Post::where('tipo', 'noticia')
                ->where('created_at', '<', Carbon::now()->subYear(2))
                ->delete();
    }

    public function clearTrash()
    {
        $posts = Post::where('tipo', 'noticia')
                ->where('deleted_at', '<', Carbon::now()->subMonths(6))
                ->onlyTrashed()
                ->get();

        if(!empty($posts) && $posts->count() > 0){
            foreach($posts as $post){
                $imageDelete = PostGb::where('post', $post->id)->first();
                if($imageDelete){
                    Storage::delete($imageDelete->path);
                    Storage::deleteDirectory('noticias/'.$post->id);
                }
                $post->forceDelete();
            } 
        }
                
    }
}
