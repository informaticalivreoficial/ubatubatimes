<?php

namespace App\Livewire\Dashboard\Vendas;

use App\Models\AdContract;
use Livewire\Attributes\On;
use Livewire\Component;

class AdContractIndex extends Component
{
    public function delete($id)
    {
        $this->dispatch('swal:confirm', [
            'title'          => 'Excluir Contrato?',
            'text'           => 'Essa ação não pode ser desfeita.',
            'icon'           => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText'  => 'Cancelar',
            'confirmEvent'   => 'deleteContract',
            'confirmParams'  => [$id],
        ]);
    }

    #[On('deleteContract')]
    public function deleteContract($id): void
    {
        try {
            AdContract::findOrFail($id)->delete();

            $this->dispatch('swal:success', [
                'title'             => 'Excluído!',
                'text'              => 'Contrato removido com sucesso!',
                'timer'             => 2000,
                'showConfirmButton' => false,
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'icon'  => 'error',
                'text'  => 'Não foi possível excluir o contrato.',
            ]);
        }
    }

    public function generateInvoice($id): void
    {
        try {
            $contract = AdContract::findOrFail($id);

            // Bloqueia geração se for contrato free
            if ($contract->free) {
                $this->dispatch('swal:warning', [
                    'title' => 'Atenção!',
                    'icon'  => 'warning',
                    'text'  => 'Contratos free não geram fatura.',
                ]);
                return;
            }

            $contract->generateInvoice();

            $this->dispatch('swal:success', [
                'title'             => 'Fatura gerada!',
                'text'              => 'A fatura foi criada com sucesso.',
                'timer'             => 2000,
                'showConfirmButton' => false,
            ]);

        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'icon'  => 'error',
                'text'  => 'Não foi possível gerar a fatura.',
            ]);
        }
    }

    public function render()
    {
        $contracts = AdContract::with(['company', 'plan'])->latest()->get();

        return view('livewire.dashboard.vendas.ad-contract-index', [
            'contracts' => $contracts,
            'title'     => 'Lista de Contratos', 
        ]);
    }
}
