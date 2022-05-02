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
            ->add('/blog/artigos')
            ->add('/quem-somos')
            ->add('/portifolio')
            ->add('/consultoria/produtos')
            ->add('/consultoria/orcamento')            
            ->writeToFile('sitemap.xml'); 
        
        return response()->json(['success' => true]);
    }
}
