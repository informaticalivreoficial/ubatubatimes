<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ConfigService;
use Carbon\Carbon;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapUpdate extends Command
{
    protected $configService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sitemap:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Atualiza o Sitemap do sistema a cada 3 dias';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ConfigService $configService)
    {
        $this->configService = $configService;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
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
    }
}
