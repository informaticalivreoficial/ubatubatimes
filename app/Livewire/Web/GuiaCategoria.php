<?php

namespace App\Livewire\Web;

use App\Models\CatCompany;
use App\Models\Company;
use Livewire\Component;
use Livewire\WithPagination;

class GuiaCategoria extends Component
{
    use WithPagination;

    public string $slug = '';

    public string $search = '';

    public ?string $subcategoryId = null;

    public string $sort = 'relevance';

    public $categoria = null;

    protected $queryString = [
        'search'        => ['except' => ''],
        'subcategoryId' => ['except' => ''],
        'sort'          => ['except' => 'relevance'],
    ];

    public function mount(string $slug): void
    {
        $this->slug = $slug;
        $this->categoria = CatCompany::where('slug', $slug)->active()->first();

        abort_if(!$this->categoria, 404);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatedSubcategoryId(): void
    {
        $this->resetPage();
    }

    public function updatingSort(): void
    {
        $this->resetPage();
    }

    public function render()
    {
        $subcategories = CatCompany::where('id_pai', $this->categoria->id)
            ->active()
            ->orderByRaw('LOWER(title)')
            ->get();

        $term = "%{$this->search}%";

        $empresas = Company::query()
            ->with([
                'categoriaObject:id,slug,title',
                'subcategoriaObject:id,slug,title',
            ])
            ->available()
            // Sem busca: filtra pela categoria atual
            ->when(
                empty($this->search),
                fn ($q) => $q->where('category_id', $this->categoria->id)
            )
            // Com busca: pesquisa em TODAS as empresas
            ->when($this->search, function ($q) use ($term) {
                $q->where(function ($sub) use ($term) {
                    $sub->where('alias_name', 'like', $term)
                        ->orWhere('social_name', 'like', $term)
                        ->orWhere('content', 'like', $term)
                        ->orWhere('neighborhood', 'like', $term)
                        ->orWhere('city', 'like', $term)
                        ->orWhere('responsable_name', 'like', $term);
                });
            })
            // Subcategoria filtra em ambos os cenários
            ->when($this->subcategoryId, function ($q) {
                $q->where('sub_category_id', $this->subcategoryId);
            })
            ->orderByRaw($this->sortSql())
            ->paginate(12);

        return view('web.livewire.guia-categoria', [
            'empresas'      => $empresas,
            'subcategories' => $subcategories,
        ]);
    }

    private function sortSql(): string
    {
        return match ($this->sort) {
            'name'   => 'LOWER(alias_name) ASC',
            'views'  => 'views DESC',
            'recent' => 'created_at DESC',
            default  => 'client DESC, views DESC',
        };
    }
}
