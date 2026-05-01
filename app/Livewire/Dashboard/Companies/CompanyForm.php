<?php

namespace App\Livewire\Dashboard\Companies;

use App\Models\CatCompany;
use App\Models\Company;
use App\Models\CompanyGb;
use App\Models\Config;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Livewire\Attributes\On;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;
use Illuminate\Validation\ValidationException;

class CompanyForm extends Component
{
    use WithFileUploads;

    public ?Company $company = null;

    public $logo;
    public ?string $logoPath = null;

    public $metaimg;
    public ?string $metaimgPath = null;

    public $categories = [];
    public $subcategories = [];

    public $category_id = null;
    public $sub_category_id = null;

    public string $currentTab = 'dados'; 

    public array $images = [];
    public $savedImages = [];  
    
    public array $metatags = [];

    public ?string $caption_img_cover = null;

    public ?string $responsable_name = null;
    public ?string $responsable_email = null;
    public ?string $responsable_cpf = null;
    public ?string $social_name = null;
    public ?string $alias_name = null;
    public ?string $document_company = null;
    public ?string $document_company_secondary = null;
    public ?string $information = null;

        
    
    public ?string $content = null;
    public ?string $url = null;
    public ?string $first_year = null;
    public ?string $maps = null;

    public ?string $status    = '0';
    public ?string $guia      = '0';
    public ?string $client    = '0';
    public ?string $highlight = '0';
    public ?string $facebook = null;
    public ?string $twitter = null;
    public ?string $instagram = null;
    public ?string $linkedin = null;

    //Contact
    public $phone, $cell_phone, $whatsapp, $email, $additional_email, $telegram;
    //Address
    public $zipcode = '', $street, $neighborhood, $city, $state, $complement, $number;

    protected function rules()
    {
        $companyId = $this->company->id ?? null;

        return [
            'alias_name' => 'required|string|max:255',
            'responsable_name' => 'required|string|max:255',
            'responsable_email' => 'required|string|email|max:255',
            'zipcode' => 'required|min:8|max:10',
            'email' => ['required', 'email', Rule::unique('companies', 'email')->ignore($companyId)],
            'cell_phone' => 'required|string|min:15',
            'logo' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:1024',
            'metaimg' => 'nullable|file|mimes:jpeg,jpg,png,webp|max:1024',
        ];
    }    

    public function mount(Company $company)
    {
        $this->company = $company;

        // categorias principais
        $this->categories = CatCompany::whereNull('id_pai')
            ->where('status', 1)
            ->orderBy('title')
            ->get();

        if ($company->exists) {
            $this->logoPath = $company->logo; // 👈 essencial
            $this->metaimgPath = $company->metaimg; // 👈 essencial

            $data = collect($company->toArray())
                ->except(['metatags'])
                ->toArray();
            $this->fill($data);

            $this->status    = (string) (int) ($company->status    ?? false);
            $this->guia      = (string) (int) ($company->guia      ?? false);
            $this->client    = (string) (int) ($company->client    ?? false);
            $this->highlight = (string) (int) ($company->highlight ?? false);

            // Metatags como array
            $this->metatags = is_string($company->metatags)
                ? explode(',', $company->metatags)
                : [];

            // Carrega as subcategorias da categoria já salva
            if ($this->category_id) {
                $this->subcategories = CatCompany::where('id_pai', $this->category_id)
                    ->where('status', 1)
                    ->orderBy('title')
                    ->get();
            }
        }
    }

    public function updatedCategoryId($value)
    {
        $this->sub_category_id = null;

        $this->subcategories = CatCompany::where('id_pai', $value)
            ->where('status', 1)
            ->orderBy('title')
            ->get();
    }

    public function save(string $mode = 'draft')
    {
        // 🔹 Regras dinâmicas
        $rules = $this->rules();

        if (! $this->logo instanceof TemporaryUploadedFile) {
            unset($rules['logo']);
        }

        if (! $this->metaimg instanceof TemporaryUploadedFile) {
            unset($rules['metaimg']);
        }

        // 🔹 Validação
        $validated = $this->validate($rules);

        // 🔹 Ajustes
        $validated['metatags'] = implode(',', $this->metatags ?? []);
        $validated['status']   = $mode === 'published' ? 1 : 0;

        // 🔹 Monta payload
        $data = [
            'responsable_name' => $validated['responsable_name'],
            'responsable_email' => $this->responsable_email,
            'responsable_cpf' => $this->responsable_cpf,

            'alias_name' => $validated['alias_name'],
            'email' => $validated['email'],

            'metatags' => $validated['metatags'],
            'maps' => $this->maps,

            'status' => $validated['status'],
            'guia' => $this->guia ?? 0,
            'client' => $this->client ?? 0,
            'highlight' => $this->highlight ?? 0,

            'url' => $this->url,
            'first_year' => $this->first_year,
            'content' => $this->content,

            'category_id' => $this->category_id,
            'sub_category_id' => $this->sub_category_id,

            'social_name' => $this->social_name,
            'zipcode' => $this->zipcode,
            'street' => $this->street,
            'neighborhood' => $this->neighborhood,
            'city' => $this->city,
            'state' => $this->state,
            'complement' => $this->complement,
            'number' => $this->number,

            'additional_email' => $this->additional_email,
            'document_company' => $this->document_company,
            'document_company_secondary' => $this->document_company_secondary,
            'information' => $this->information,

            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,

            'phone' => $this->phone,
            'whatsapp' => $this->whatsapp,
            'telegram' => $this->telegram,
            'cell_phone' => $validated['cell_phone'],
        ];

        // 🔹 Create ou Update
        if ($this->company->exists) {
            $this->company->update($data);
        } else {
            $this->company = Company::create($data);
        }

        // 🔹 Agora já tem ID
        $folder = 'company/' . $this->company->id;

        // 🔹 Upload logo
        if ($this->logo instanceof TemporaryUploadedFile) {
            if ($this->logoPath) {
                Storage::disk('public')->delete($this->logoPath);
            }

            $this->logoPath = $this->logo->store($folder, 'public');

            $this->company->update([
                'logo' => $this->logoPath
            ]);
        }

        // 🔹 Upload metaimg
        if ($this->metaimg instanceof TemporaryUploadedFile) {
            if ($this->metaimgPath) {
                Storage::disk('public')->delete($this->metaimgPath);
            }

            $this->metaimgPath = $this->metaimg->store($folder, 'public');

            $this->company->update([
                'metaimg' => $this->metaimgPath
            ]);
        }

        // 🔹 Validação imagens múltiplas
        $this->validate([
            'images.*' => 'image|mimes:jpeg,jpg,png,webp|max:2048',
        ]);

        $maxImages = config('app.max_images');
        $existingImages = $this->company->images()->count();
        $allowed = $maxImages - $existingImages;

        if (count($this->images ?? []) > $allowed) {
            $this->dispatch('swal:warning', [
                'title' => 'Atenção!',
                'text' => "Limite de {$maxImages} imagens atingido.",
                'icon' => 'warning',
                'showConfirmButton' => false
            ]);
            return;
        }

        $manager = new ImageManager(new Driver());

        foreach ($this->images as $index => $image) {

            if ($index >= $allowed) break;

            $filename = uniqid() . '.webp';
            $path = "{$folder}/{$filename}";

            $img = $manager->read($image->getRealPath())
                ->scaleDown(width: 1920)
                ->toWebp(85);

            Storage::disk('public')->put($path, $img);

            $maxOrder = CompanyGb::where('company', $this->company->id)->max('order_img') ?? 0;

            CompanyGb::create([
                'company' => $this->company->id,
                'path' => $path,
                'cover' => $this->cover ?? null,
                'order_img' => $maxOrder + $index + 1,
                'watermark' => false
            ]);
        }

        $this->reset('images');

        // 🔹 Feedback
        $this->dispatch('swal:success', [
            'title' => 'Sucesso!',
            'text' => $this->company->wasRecentlyCreated
                ? 'Empresa cadastrada com sucesso!'
                : 'Empresa atualizada com sucesso!',
            'timer' => 2000,
            'showConfirmButton' => false
        ]);

        // 🔹 Redirect
        if ($this->company->wasRecentlyCreated) {
            return redirect()->route('companies.edit', $this->company);
        }
    }

    //Remover imagem temporária
    public function removeTempImage($index)
    {
        unset($this->images[$index]);
        $this->images = array_values($this->images);
    }

    //Remover imagem do Bd
    public function removeSavedImage($id)
    {
        $image = CompanyGb::find($id);
        if ($image) {
            Storage::disk('public')->delete($image->path);
            $image->delete();
            $this->savedImages = collect($this->savedImages)->filter(fn ($img) => $img->id !== $id);
            $this->company->refresh(); // Para garantir que os dados estejam atualizados
        }
    }

    public function toggleCover($imageId)
    {
        $image = CompanyGb::where('id', $imageId)->where('company', $this->company->id)->first();

        if ($image) {
            if ($image->cover) {
                // Se já é capa, remove
                $image->update(['cover' => 0]);
            } else {
                // Remove capa das outras e define esta
                CompanyGb::where('company', $this->company->id)->update(['cover' => 0]);
                $image->update(['cover' => 1]);
            }

            // Atualiza a relação para refletir na view
            $this->company->refresh();
        }
    }

    public function updatedZipcode(string $value)
    {
        $cep = preg_replace('/[^0-9]/', '', $value);

        if (strlen($cep) === 8) {
            $response = Http::get("https://viacep.com.br/ws/{$cep}/json/")->json();

            if (!isset($response['erro'])) {
                $this->street = $response['logradouro'] ?? '';
                $this->neighborhood = $response['bairro'] ?? '';
                $this->state = $response['uf'] ?? '';
                $this->city = $response['localidade'] ?? '';
                //$this->configData['complement'] = $response['complemento'] ?? '';
            } else {
                $this->addError('zipcode', 'CEP não encontrado.'); 
            }
        }
    }    

    public function getLogoUrlProperty()
    {
        if ($this->logo instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            return $this->logo->temporaryUrl();
        }

        if ($this->logoPath && Storage::disk('public')->exists($this->logoPath)) {
            return Storage::url($this->logoPath);
        }

        return asset('theme/images/image.jpg');
    }

    public function getMetaimgUrlProperty()
    {
        if ($this->metaimg instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
            return $this->metaimg->temporaryUrl();
        }

        if ($this->metaimgPath && Storage::disk('public')->exists($this->metaimgPath)) {
            return Storage::url($this->metaimgPath);
        }

        return asset('theme/images/image.jpg');
    }

    #[On('updateContent')]
    public function updateContent($value)
    {
        $this->content = $value;
    }

    public function updateImageOrder($order)
    {
        try {
            foreach ($order as $item) {
                CompanyGb::where('id', $item['id'])
                    ->where('company', $this->company->id)
                    ->update(['order_img' => $item['position']]);
            }
            
            // Atualiza a propriedade para refletir a nova ordem
            $this->company->refresh();
            
        } catch (\Exception $e) {
            $this->toastError('Erro ao atualizar ordem das imagens: ' . $e->getMessage());
        }
    }

    public function applyWatermarkImage($imageId)
    {
        $image = CompanyGb::find($imageId);

        if ($image->watermarked) {
            return;
        }

        $config = Config::first();

        $manager = new ImageManager(new Driver());

        $img = $manager->read(storage_path('app/public/'.$image->path));
        $watermark = $manager->read(storage_path('app/public/'.$config->watermark));

        $img->place($watermark, 'bottom-right', 30, 30);
        $img->save();

        $image->update([
            'watermark' => true
        ]);

        $this->dispatch('swal:success', [
            'title' => false,
            'text' => 'Marca d’água aplicada!',
            'timer' => 2000,
            'showConfirmButton' => false
        ]);
    }

    public function updatedImages(): void
    {
        $hasHeic = collect($this->images)->contains(function ($image) {
            return strtolower($image->getClientOriginalExtension()) === 'heic';
        });

        if ($hasHeic) {
            $this->dispatch('swal:warning', [
                'title' => 'Formato não suportado!',
                'text'  => 'Imagens no formato HEIC (iPhone) não são aceitas. Converta para JPG ou PNG antes de enviar.',
                'icon'  => 'warning',
            ]);

            $this->reset('images');
        }
    }

    public function render()
    {
        $title = $this->company->exists ? 'Editar Empresa' : 'Cadastrar Empresa';
        return view('livewire.dashboard.companies.company-form')->with('title', $title);
    }
}
