<?php

namespace App\Livewire\Dashboard\Vendas;

use App\Models\Ad;
use Livewire\Attributes\On;
use Livewire\Component;

class AdIndex extends Component
{
    public string $search  = '';
    public string $sortField = 'created_at';
    public string $sortDirection = 'desc';

    public function sortBy(string $field): void
    {
        $this->sortDirection = $this->sortField === $field && $this->sortDirection === 'asc'
            ? 'desc'
            : 'asc';

        $this->sortField = $field;
    }

    public function delete($id): void
    {
        $this->dispatch('swal:confirm', [
            'title'             => 'Excluir Anúncio?',
            'text'              => 'Essa ação não pode ser desfeita.',
            'icon'              => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText'  => 'Cancelar',
            'confirmEvent'      => 'deleteAd',
            'confirmParams'     => [$id],
        ]);
    }

    #[On('deleteAd')]
    public function deleteAd($id): void
    {
        try {
            Ad::findOrFail($id)->delete();

            $this->dispatch('swal:success', [
                'title'             => 'Excluído!',
                'text'              => 'Anúncio removido com sucesso!',
                'timer'             => 2000,
                'showConfirmButton' => false,
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'icon'  => 'error',
                'text'  => 'Não foi possível excluir o anúncio.',
            ]);
        }
    }
    
    public function render()
    {
        $ads = Ad::with(['company', 'plan', 'contract'])
            ->when($this->search, fn ($q) =>
                $q->whereHas('company', fn ($q) =>
                    $q->where('alias_name', 'like', "%{$this->search}%")
                )
                ->orWhereHas('plan', fn ($q) =>
                    $q->where('name', 'like', "%{$this->search}%")
                )
            )
            ->orderBy($this->sortField, $this->sortDirection)
            ->get();

        return view('livewire.dashboard.vendas.ad-index', [
            'ads'   => $ads,
            'title' => 'Listar Anúncios',
        ]);
    }
}
