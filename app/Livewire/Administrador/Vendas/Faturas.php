<?php

namespace App\Livewire\Administrador\Vendas;

use Livewire\Component;
use Livewire\WithPagination;

class Faturas extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public string $sortField = 'name';

    public string $sortDirection = 'asc';

    public function render()
    {
        $faturas = \App\Models\Fatura::query()->when($this->search, function($query){
            $query->orWhere('name', 'LIKE', "%{$this->search}%");
            $query->orWhere('email', "%{$this->search}%");
        })->where('client', 1)->orderBy($this->sortField, $this->sortDirection)->paginate(55);
        return view('livewire.administrador.vendas.faturas',[
        'faturas' => $faturas
        ]);
    }
}
