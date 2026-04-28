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
            'title' => 'Excluir Contrato?',
            'text' => 'Essa ação não pode ser desfeita.!',
            'showConfirmButton' => false,
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteContract',
            'confirmParams' => [$id],
        ]);
    }

    #[On('deleteContract')]
    public function deleteContract($id): void
    {
        try {
            $contract = AdContract::findOrFail($id);
            $contract->delete();

            $this->dispatch('swal:success', [
                'title' => 'Excluído!',
                'text' => 'Contrato removido com sucesso!',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'icon'  => 'error',
                'text'  => 'Não foi possível excluir o contrato.',
            ]);
        }
    }

    public function generateInvoice($id)
    {
        $contract = AdContract::findOrFail($id);

        $invoice = $contract->generateInvoice();

        // aqui você pode já integrar com PagHiper depois

        session()->flash('success', 'Fatura gerada!');
    }

    public function render()
    {
        $title = 'Lista de Faturas';

        $contracts = AdContract::with(['company', 'plan'])->latest()->get();
        return view('livewire.dashboard.vendas.ad-contract-index', compact('contracts'))->with('title', $title);
    }
}
