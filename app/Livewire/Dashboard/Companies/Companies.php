<?php

namespace App\Livewire\Dashboard\Companies;

use App\Models\Company;
use App\Models\Config;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class Companies extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public string $search = '';

    public string $sortField = 'social_name';

    public string $sortDirection = 'desc';

    public ?int $delete_id = null;

    public $showCompanyModal = false;
    public $companySelected;    

    #{Url}
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function sortBy(string $field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }  
    
    public function toggleHighlight(Company $company)
    {
        $company->highlight = !$company->highlight;
        $company->save();        
    }

    public function toggleStatus($id)
    {              
        $company = Company::findOrFail($id);
        $company->status = !$company->status;        
        $company->save();
    }

    public function setDeleteId($id)
    {
        $this->dispatch('swal:confirm', [
            'title' => 'Excluir Empresa?',
            'text' => 'Essa ação não pode ser desfeita.!',
            'showConfirmButton' => false,
            'icon' => 'warning',
            'confirmButtonText' => 'Sim, excluir',
            'cancelButtonText' => 'Cancelar',
            'confirmEvent' => 'deleteCompany',
            'confirmParams' => [$id],
        ]);       
    }

    #[On('deleteCompany')]
    public function deleteCompany($id): void
    {
        try {
            $company = Company::findOrFail($id);

            //$folder = 'company/' . $company->id;
            //Storage::disk()->deleteDirectory($folder);

            // $logoPath = $company->logo;
            // if ($logoPath && Storage::disk()->exists($logoPath)) {
            //     Storage::disk()->delete($logoPath);
            // }

            // $metaimgPath = $company->metaimg;
            // if ($metaimgPath && Storage::disk()->exists($metaimgPath)) {
            //     Storage::disk()->delete($metaimgPath);
            // }

            $company->delete();

            $this->delete_id = null;

            $this->dispatch('swal:success', [
                'title' => 'Excluído!',
                'text' => 'Empresa removida com sucesso!',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Erro!',
                'icon'  => 'error',
                'text'  => 'Não foi possível excluir a empresa.',
            ]);
        }
    }

    public function applyWatermark(Company $company)
    {      

        $config = Config::first();

        if (!$config || !$config->watermark) {
            $this->dispatch('swal:error', [
                'title' => false,
                'text' => 'Nenhuma marca d’água configurada!',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
            return;
        }

        if (!Storage::disk()->exists($config->watermark)) {
            $this->dispatch('swal:error', [
                'title' => false,
                'text' => 'Arquivo de marca d’água não encontrado!',
                'timer' => 2000,
                'showConfirmButton' => false
            ]);
            return;
        }

        $manager = new ImageManager(new Driver());

        $watermark = $manager->read(Storage::disk()->get($config->watermark));

        foreach ($company->images as $image) {

            if ($image->watermark) {
                continue; // pula se já tiver marca
            }

            if (Storage::disk()->exists($image->path)) {

                $img = $manager->read(Storage::disk()->get($image->path));
                $img->place($watermark, 'bottom-right', 30, 30);

                Storage::disk()->put($image->path, (string) $img->encode());

                $image->update([
                    'watermark' => true
                ]);
            }
        }

        $this->dispatch('swal:success', [
            'title' => false,
            'text' => 'Marca d’água aplicada!',
            'timer' => 2000,
            'showConfirmButton' => false
        ]);        

        $company->refresh();
    }

    public function render()
    {
        $title = 'Lista de Empresas';
        $companies = Company::query()->when($this->search, function($query){
            $query->orWhere('social_name', 'LIKE', "%{$this->search}%");
            $query->orWhere('email', 'LIKE', "%{$this->search}%");
        })->orderBy($this->sortField, $this->sortDirection)->paginate(35);
        return view('livewire.dashboard.companies.companies',[
            'companies' => $companies
        ])->with('title', $title);
    }
}
