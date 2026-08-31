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

        $empresas = Company::query()
            ->with([
                'categoriaObject:id,slug,title',
                'subcategoriaObject:id,slug,title',
                'images:id,company,path,cover',
            ])
            ->where('category_id', $this->categoria->id)
            ->available()
            ->when($this->search, function ($q) {
                $q->where(function ($sub) {
                    $sub->where('alias_name', 'like', "%{$this->search}%")
                        ->orWhere('content', 'like', "%{$this->search}%");
                });
            })
            ->when($this->subcategoryId, function ($q) {
                $q->where('sub_category_id', $this->subcategoryId);
            })
            ->orderByRaw($this->sortSql())
            ->paginate(18);

        return view('web.livewire.guia-categoria', [
            'empresas'      => $empresas,
            'subcategories' => $subcategories,
        ]);
    }

    private function sortSql(): string
    {
        return match ($this->sort) {
            'name'      => 'LOWER(alias_name) ASC',
            'views'     => 'views DESC',
            'recent'    => 'created_at DESC',
            default     => 'client DESC, views DESC',
        };
    }
}
