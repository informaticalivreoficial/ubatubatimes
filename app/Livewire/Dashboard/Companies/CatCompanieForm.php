<?php

namespace App\Livewire\Dashboard\Companies;

use App\Models\CatCompany;
use Livewire\Component;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;

class CatCompanieForm extends Component
{
    public ?int $id = null;
    public ?string $title = null;
    public int $status = 1;
    public ?string $type = null;
    public ?int $parentId = null;

    #[On('loadCategory')]
    public function loadCategory($payload = [])
    {
        // Garante que pegamos a chave correta
        $data = $payload['payload'] ?? $payload;

        // Edição
        if (!empty($data['editId'])) {
            $category = CatCompany::find($data['editId']);
            if ($category) {
                $this->id       = $category->id;
                $this->title    = $category->title;
                $this->status   = $category->status;
                $this->type     = $category->type;
                $this->parentId = $category->id_pai;
            }
        }

        // Nova subcategoria
        if (!empty($data['categoryId'])) {
            $this->parentId = $data['categoryId'];
            $parent = CatCompany::find($this->parentId);
            if ($parent) {
                $this->type = $parent->type;
            }
        }
    }

    public function save(): void
    {        
        $this->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|boolean',
            'parentId' => 'nullable|exists:cat_companies,id',
        ]);

        CatCompany::updateOrCreate(
            ['id' => $this->id],
            [
                'title' => $this->title,
                'status' => $this->status,
                'id_pai' => $this->parentId,
            ]
        );

        // Fecha modal
        $this->dispatch('category-saved');

        $this->resetForm();
    }

    #[On('resetForm')]
    public function resetForm()
    {
        $this->reset(['id', 'title', 'status', 'parentId']);
        $this->status = 1;
    }

    public function getModalTitleProperty()
    {
        if ($this->id && $this->parentId) {
            return 'Editar Subcategoria';
        }

        if ($this->id) {
            return 'Editar Categoria';
        }

        if ($this->parentId) {
            return 'Cadastrar Subcategoria';
        }

        return 'Cadastrar Nova Categoria';
    }

    public function render()
    {
        return view('livewire.dashboard.companies.cat-companie-form');
    }
}
