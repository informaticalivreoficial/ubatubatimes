<?php

namespace App\Livewire\Dashboard\Vendas;

use App\Models\Ad;
use App\Models\AdContract;
use App\Models\Company;
use App\Models\Plan;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class AdForm extends Component
{
    use WithFileUploads;

    public $ad;

    public $company_id;
    public $plan_id;
    public $ad_contract_id;
    public $title;

    public $image;
    public ?string $imagePath = null;

    public $link;
    public $start_date;
    public $end_date;
    public $active = true;

    public function mount(Ad $ad = null)
    {
        if ($ad && $ad->exists) {
            $this->ad = $ad;
            $this->fill($ad->toArray());
        }
    }

    // Filtra contratos ao trocar empresa
    public function updatedCompanyId($value): void
    {
        $this->ad_contract_id = null;
    }

    public function save(): void
    {
        $isNew = !($this->ad->id ?? null);

        $data = $this->validate([
            'company_id'     => 'required',
            'plan_id'        => 'required',
            'ad_contract_id' => 'nullable|exists:ad_contracts,id',
            'title'          => 'nullable|string|max:255',
            'image'          => $isNew ? 'required|file|mimes:jpeg,jpg,png,webp|max:2048' : 'nullable|file|mimes:jpeg,jpg,png,webp|max:2048',
            'link'           => 'nullable|url',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'active'         => 'boolean',
        ]);

        if ($this->image instanceof TemporaryUploadedFile) {
            // Apaga imagem antiga se existir
            if ($this->imagePath) {
                Storage::disk('public')->delete($this->imagePath);
            }

            // Salva na pasta ads/{id} se edição, ou ads/temp se novo
            $folder = $this->ad?->id ? 'ads/' . $this->ad->id : 'ads';
            $data['image'] = $this->image->store($folder, 'public');
        } else {
            unset($data['image']);
        }

        $ad = Ad::updateOrCreate(
            ['id' => $this->ad->id ?? null],
            $data
        );

        // Se era novo, move imagem para pasta correta com o ID gerado
        if ($isNew && isset($data['image'])) {
            $newPath = 'ads/' . $ad->id . '/' . basename($data['image']);
            Storage::disk('public')->move($data['image'], $newPath);
            $ad->update(['image' => $newPath]);
        }

        $this->dispatch('swal:success', [
            'title'             => 'Sucesso!',
            'text'              => $isNew ? 'Anúncio cadastrado com sucesso!' : 'Anúncio atualizado com sucesso!',
            'timer'             => 2000,
            'showConfirmButton' => false,
        ]);

        redirect()->route('vendas.ads.index');
    }

    public function getImageUrlProperty()
    {
        if ($this->image instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            return $this->image->temporaryUrl();
        }

        if ($this->imagePath && Storage::disk('public')->exists($this->imagePath)) {
            return Storage::url($this->imagePath);
        }

        return asset('theme/images/image.jpg');
    }

    public function render()
    {
        // Filtra contratos pela empresa selecionada
        $contracts = $this->company_id
            ? AdContract::where('company_id', $this->company_id)
                ->get()
                ->mapWithKeys(fn ($c) => [$c->id => "Contrato #{$c->id} — {$c->plan->name}"])
            : collect();

        return view('livewire.dashboard.vendas.ad-form', [
            'companies' => Company::pluck('alias_name', 'id'),
            'plans'     => Plan::pluck('name', 'id'),
            'contracts' => $contracts,
            'title'     => $this->ad ? 'Editar Anúncio' : 'Novo Anúncio',
        ]);
    }
}
