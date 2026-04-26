<?php

namespace App\Livewire\Dashboard\Vendas;

use App\Models\Ad;
use Livewire\Component;

class AdIndex extends Component
{
    public function delete($id)
    {
        Ad::findOrFail($id)->delete();
    }
    
    public function render()
    {
        $ads = Ad::with(['company', 'plan', 'contract'])->latest()->get();

        return view('livewire.dashboard.vendas.ad-index',[
            'ads' => $ads,
        ]);
    }
}
