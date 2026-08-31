<?php

namespace App\Livewire\Dashboard\Posts;

use App\Jobs\ImportCaraguatatubaNoticias;
use App\Jobs\ImportFundartNoticias;
use App\Jobs\ImportIlhabelaNoticias;
use App\Jobs\ImportPmSPNoticias;
use App\Jobs\ImportSaoSebastiaoNoticias;
use App\Jobs\ImportTamoiosNoticias;
use App\Jobs\ImportUbatubaNoticias;
use Livewire\Component;

class Crawlers extends Component
{
    public array $selected = [];

    public bool $syncing = false;

    public array $results = [];

    private array $crawlers = [
        [
            'id' => 'ubatuba',
            'name' => 'Ubatuba',
            'description' => 'Prefeitura de Ubatuba',
            'job' => ImportUbatubaNoticias::class,
        ],
        [
            'id' => 'caraguatatuba',
            'name' => 'Caraguatatuba',
            'description' => 'Prefeitura de Caraguatatuba',
            'job' => ImportCaraguatatubaNoticias::class,
        ],
        [
            'id' => 'sao-sebastiao',
            'name' => 'São Sebastião',
            'description' => 'Prefeitura de São Sebastião',
            'job' => ImportSaoSebastiaoNoticias::class,
        ],
        [
            'id' => 'ilhabela',
            'name' => 'Ilhabela',
            'description' => 'Prefeitura de Ilhabela',
            'job' => ImportIlhabelaNoticias::class,
        ],
        [
            'id' => 'fundart',
            'name' => 'FundArt',
            'description' => 'FundArt Ubatuba',
            'job' => ImportFundartNoticias::class,
        ],
        [
            'id' => 'tamoios',
            'name' => 'Tamoios',
            'description' => 'Concessionária Tamoios',
            'job' => ImportTamoiosNoticias::class,
        ],
        [
            'id' => 'pmsp',
            'name' => 'PMSP',
            'description' => 'Portal de Notícias PMESP',
            'job' => ImportPmSPNoticias::class,
        ],
    ];

    public function getCrawlersProperty(): array
    {
        return $this->crawlers;
    }

    public function selectAll(): void
    {
        $this->selected = array_column($this->crawlers, 'id');
    }

    public function deselectAll(): void
    {
        $this->selected = [];
    }

    public function sync(): void
    {
        if (empty($this->selected)) {
            $this->dispatch('swal', [
                'title' => 'Atenção!',
                'icon' => 'warning',
                'text' => 'Selecione pelo menos um crawler para sincronizar.',
            ]);

            return;
        }

        $this->syncing = true;
        $this->results = [];

        foreach ($this->crawlers as $crawler) {
            if (in_array($crawler['id'], $this->selected)) {
                $crawler['job']::dispatch();

                $this->results[] = [
                    'name' => $crawler['name'],
                    'status' => 'dispatched',
                ];
            }
        }

        $this->syncing = false;

        $count = count($this->selected);

        $this->dispatch('swal:success', [
            'title' => 'Sincronização iniciada!',
            'text' => $count . ' crawler' . ($count > 1 ? 's' : '') . ' enviado' . ($count > 1 ? 's' : '') . ' para a fila de processamento.',
            'timer' => 3000,
            'showConfirmButton' => false,
        ]);
    }

    public function render()
    {
        return view('livewire.dashboard.posts.crawlers');
    }
}
