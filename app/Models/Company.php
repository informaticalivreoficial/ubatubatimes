<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'uuid',
        'api_token',

        'client',
        'category_id',
        'sub_category_id',
        
        'guia',
        'content',
        'url',
        'slug',
        'first_year',
        'metatags',
        'maps',
        'logo',
        'metaimg',
        'caption_img_cover',
        'highlight',

        'magic_token',
        'magic_token_expires_at',
        'responsable_name',
        'responsable_email',
        'responsable_cpf',
        'social_name',
        'alias_name',
        'document_company',
        'document_company_secondary',
        'information',
        'status',
        //Redes Sociais
        'facebook', 'twitter', 'instagram', 'linkedin',
        //contact 
        'phone', 'cell_phone', 'whatsapp', 'telegram', 'email', 'additional_email',
        //Address      
        'zipcode', 'street', 'number', 'complement', 'neighborhood', 'state', 'city',
    ];

    protected $casts = [
        'status' => 'boolean',
        'client' => 'boolean',
        'guia' => 'boolean',
        'magic_token_expires_at' => 'datetime',
        'highlight' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();        
    }

    protected static function booted()
    {
        static::saving(function ($company) {
            $company->setSlug();
        });

        static::creating(function ($company) {
            $company->uuid      = Str::uuid();
            $company->api_token = Str::random(64);
        });

        static::deleting(function ($company) {
            // Deleta a pasta inteira com todas as imagens
            Storage::disk('public')->deleteDirectory("company/{$company->id}");

            // Deleta os registros do banco
            $company->images()->delete();
        });
    }

    // Gera novo token manualmente se precisar
    public function regenerateToken(): string
    {
        $token = Str::random(64);
        $this->update(['api_token' => $token]);
        return $token;
    }

    /**
     * Scopes
    */
    public function scopeAvailable($query)
    {
        return $query->where('status', 1);
    }

    public function scopeUnavailable($query)
    {
        return $query->where('status', 0);
    }

    /**
     * Relationships
    */ 
    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function contracts()
    {
        return $this->hasMany(AdContract::class);
    }
    
    public function categoriaObject()
    {
        return $this->belongsTo(CatCompany::class, 'category_id');
    }

    public function subcategoriaObject()
    {
        return $this->belongsTo(CatCompany::class, 'sub_category_id');
    }

    public function images()
    {
        return $this->hasMany(CompanyGb::class, 'company', 'id')
                    ->orderBy('order_img', 'ASC')
                    ->orderBy('cover', 'DESC'); // cover primeiro (1 antes de 0)
    }

    public function hasImagesWithoutWatermark()
    {
        return $this->images->where('watermark', false)->isNotEmpty();
    }

    /**
     * Accerssors and Mutators
    */
    public function getlogo()
    {
        if(empty($this->logo) || !Storage::disk()->exists($this->logo)) {
            return asset('theme/images/image.jpg');
        } 
        return Storage::url($this->logo);
    }

    public function getmetaimg()
    {
        if(empty($this->metaimg) || !Storage::disk()->exists($this->metaimg)) {
            return url(asset('theme/images/image.jpg'));
        } 
        return Storage::url($this->metaimg);
    }

    public function logoPathForPdf(): string
    {
        if ($this->logo && file_exists(storage_path('app/public/' . $this->logo))) {
            return storage_path('app/public/' . $this->logo);
        }

        return public_path('theme/images/image.jpg');
    }

    public function getMetatagsArrayAttribute()
    {
        return $this->metatags
            ? array_map('trim', explode(',', $this->metatags))
            : [];
    }

    public function setZipcodeAttribute($value)
    {
        $this->attributes['zipcode'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getZipcodeAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return substr($value, 0, 5) . '-' . substr($value, 5, 3);
    }

    public function setDocumentCompanyAttribute($value)
    {
        $this->attributes['document_company'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getDocumentCompanyAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) .
            '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2);
    }

    public function setCellPhoneAttribute($value)
    {
        $this->attributes['cell_phone'] = (!empty($value) ? $this->clearField($value) : null);
    }
    
    public function getCellPhoneAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return  
            substr($value, 0, 0) . '(' .
            substr($value, 0, 2) . ') ' .
            substr($value, 2, 5) . '-' .
            substr($value, 7, 4) ;
    }

    public function setPhoneAttribute($value)
    {
        $this->attributes['phone'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getPhoneAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return  
            substr($value, 0, 0) . '(' .
            substr($value, 0, 2) . ') ' .
            substr($value, 2, 5) . '-' .
            substr($value, 7, 4) ;
    }

    public function setWhatsappAttribute($value)
    {
        $this->attributes['whatsapp'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getWhatsappAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return  
            substr($value, 0, 0) . '(' .
            substr($value, 0, 2) . ') ' .
            substr($value, 2, 5) . '-' .
            substr($value, 7, 4) ;
    }

    public function generateMagicToken(): string
    {
        $token = \Illuminate\Support\Str::random(64);

        $this->update([
            'magic_token'            => $token,
            'magic_token_expires_at' => now()->addMinutes(15),
        ]);

        return $token;
    }

    public function isMagicTokenValid(string $token): bool
    {
        return $this->magic_token === $token
            && $this->magic_token_expires_at
            && $this->magic_token_expires_at->isFuture();
    }

    public function setSlug()
    {
        if (!empty($this->alias_name)) {
    
            $baseSlug = Str::slug($this->alias_name);
            $slug = $baseSlug;
            $count = 1;
    
            while (
                Company::where('slug', $slug)
                    ->where('id', '!=', $this->id)
                    ->exists()
            ) {
                $slug = $baseSlug . '-' . str_pad($count, 2, '0', STR_PAD_LEFT);
                $count++;
            }
    
            $this->attributes['slug'] = $slug;
        }
    }

    private function convertStringToDate(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        list($day, $month, $year) = explode('/', $param);
        return (new \DateTime($year . '-' . $month . '-' . $day))->format('Y-m-d');
    }
    
    private function clearField(?string $param)
    {
        if (empty($param)) {
            return null;
        }
        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
