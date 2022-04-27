<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Configuracoes;

use Spatie\Sitemap\SitemapGenerator;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{  
        
    public function gerarxml(Request $request)
    {
        $configupdate = Configuracoes::where('id', $request->id)->first();
        $configupdate->sitemap_data = date('Y-m-d');
        $configupdate->sitemap = url('/sitemap.xml');
        $configupdate->save();

        Sitemap::create()->add(Url::create('/atendimento')
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.1))
            ->add('/')
            ->add('/blog')
            ->add('/blog/categoria/serie-atletas-de-ubatuba')
            ->add('/blog/categoria/praias-de-ubatuba')            
            ->add('/blog/categoria/wiki-ubatuba')
            ->add('/noticias')
            ->add('/noticias/categoria/ubatuba') 
            ->add('/noticias/categoria/caraguatatuba') 
            ->add('/noticias/categoria/sao-sebastiao') 
            ->add('/noticias/categoria/ilhabela') 
            ->add('/previsao-do-tempo')
            ->add('/boletim-das-ondas')
            ->add('/politica-de-privacidade')
            ->add('/guia-ubatuba')            
            ->writeToFile('sitemap.xml'); 
        
        return response()->json(['success' => true]);
    }
}
