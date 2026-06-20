<?php

namespace App\Livewire\Web;

use Livewire\Component;
use App\Services\BalneabilidadeService;

class Balneabilidade extends Component
{
    public string $cidade = 'UBATUBA';

    public array $praias = [];
    public array $improprias = [];
    public ?string $ultimaAtualizacao = null;

    public function mount(BalneabilidadeService $service)
    {
        $this->loadData($service);
    }

    public function updatedCidade(BalneabilidadeService $service)
    {
        $this->loadData($service);
    }

    public function loadData(BalneabilidadeService $service)
    {
        $this->praias = $service->getFeatures($this->cidade);

        $this->improprias = $service->getImprorprias($this->cidade);

        $this->ultimaAtualizacao = $service->getUltimaAtualizacao($this->cidade);
    }

    public function render()
    {
        return view('livewire.web.balneabilidade');
    }
}
