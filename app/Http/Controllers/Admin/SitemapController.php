<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Services\ConfigService;

class SitemapController extends Controller
{  
    protected $configService;

    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
    }

    public function gerarxml()
    {
        $this->configService->getConfig()->sitemap_data = date('Y-m-d');
        $this->configService->getConfig()->sitemap = url('/sitemap.xml');
        $this->configService->getConfig()->save();

        Sitemap::create()->add(Url::create('/atendimento')
            ->setLastModificationDate(Carbon::yesterday())
            ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            ->setPriority(0.1))
            ->add('/')
            ->add('/blog')
            ->add('/blog/categoria/wiki-ubatuba')
            ->add('/blog/categoria/serie-profissoes')
            ->add('/blog/categoria/praias-de-ubatuba')
            ->add('/blog/categoria/serie-atletas-de-ubatuba')
            ->add('/noticias')
            ->add('/noticias/categoria/ubatuba')
            ->add('/noticias/categoria/caraguatatuba')
            ->add('/noticias/categoria/sao-sebastiao')
            ->add('/noticias/categoria/ilhabela')
            ->add('/boletim-das-ondas')
            ->add('/previsao-do-tempo')
            ->add('/pesquisa')          
            ->add('/guia-ubatuba')          
            ->add('/politica-de-privacidade')          
            ->writeToFile('sitemap.xml'); 
        
        return response()->json(['success' => true]);
    }
}
