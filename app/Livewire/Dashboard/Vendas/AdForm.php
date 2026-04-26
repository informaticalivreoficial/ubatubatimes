<?php

namespace App\Livewire\Dashboard\Vendas;

use App\Models\Ad;
use App\Models\AdContract;
use App\Models\Company;
use App\Models\Plan;
use Livewire\Component;
use Livewire\WithFileUploads;

class AdForm extends Component
{
    use WithFileUploads;

    public $ad;

    public $company_id;
    public $plan_id;
    public $ad_contract_id;
    public $title;
    public $image;
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

    public function save()
    {
        $data = $this->validate([
            'company_id' => 'required',
            'plan_id' => 'required',
            'ad_contract_id' => 'nullable',
            'title' => 'nullable|string',
            'image' => $this->ad ? 'nullable|image' : 'required|image',
            'link' => 'nullable|url',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'active' => 'boolean',
        ]);

        if ($this->image instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $this->image->store('ads', 'public');
        } else {
            unset($data['image']);
        }

        Ad::updateOrCreate(
            ['id' => $this->ad->id ?? null],
            $data
        );

        session()->flash('success', 'Anúncio salvo com sucesso!');

        return redirect()->route('ads.index');
    }

    public function render()
    {
        return view('livewire.dashboard.vendas.ad-form',[
            'companies' => Company::pluck('alias_name', 'id'),
            'plans' => Plan::pluck('name', 'id'),
            'contracts' => AdContract::pluck('id', 'id'),
        ]);
    }
}
