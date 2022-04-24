<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Support\Cropper;

class Empresa extends Model
{
    use HasFactory;

    protected $table = 'empresas';

    protected $fillable = [
        'cat_pai',
        'categoria',
        'views',
        'exibirnoguia',
        'responsavel',
        'responsavel_email',
        'responsavel_cpf',
        'social_name',
        'alias_name',
        'slug',
        'document_company',
        'document_company_secondary',
        'status',
        'logomarca', 
        'ano_de_inicio',  
        'content',    
        'notasadicionais',  
        'dominio',
        'metaimg',
        'mapa_google',
        'metatags',      
        'cep',
        'rua',
        'num',
        'complemento',
        'bairro',
        'uf',
        'cidade',        
        'telefone',
        'celular',
        'whatsapp',
        'email',
        //Redes
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'vimeo',
        'youtube',
        'fliccr',
        'soundclound',
        'snapchat'
    ];

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
     * Relacionamentos
    */
    public function categoriaObject()
    {
        return $this->hasOne(CatEmpresa::class, 'id', 'categoria');
    }

    public function anuncios()
    {
        return $this->hasMany(Anuncio::class, 'empresa', 'id');
    }

    public function images()
    {
        return $this->hasMany(EmpresaGb::class, 'empresa', 'id')->orderBy('cover', 'ASC');
    }

    /**
     * Accerssors and Mutators
     */
    public function getmetaimg()
    {
        $image = $this->metaimg;        
        if(empty($this->metaimg) || !File::exists('../public/storage/' . $image)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 
        return Storage::url(Cropper::thumb($this->metaimg, env('METAIMG_WIDTH'), env('METAIMG_HEIGHT')));
    }

    public function cover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if(!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if(empty($cover['path']) || !File::exists('../public/storage/' . $cover['path'])) {
            return $this->nologoCover();
        }

        return Storage::url(Cropper::thumb($cover['path'], 720, 480));
    }

    public function nocover()
    {
        $images = $this->images();
        $cover = $images->where('cover', 1)->first(['path']);

        if(!$cover) {
            $images = $this->images();
            $cover = $images->first(['path']);
        }

        if(empty($cover['path']) || !File::exists('../public/storage/' . $cover['path'])) {
            return $this->nologoCover();
        }

        return Storage::url($cover['path']);
    }
    
    public function logoCover()
    {       
        if(empty($this->logomarca) || !File::exists('../public/storage/' . $this->logomarca)) {
            return url(asset('backend/assets/images/image.jpg'));
        }

        return Storage::url(Cropper::thumb($this->logomarca, 300, 300));
    }

    public function nologoCover()
    {       
        if(empty($this->logomarca) || !File::exists('../public/storage/' . $this->logomarca)) {
            return url(asset('backend/assets/images/image.jpg'));
        }

        return Storage::url($this->logomarca);
    }

    public function setDocumentCompanyAttribute($value)
    {
        $this->attributes['document_company'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getDocumentCompanyAttribute($value)
    {
        return substr($value, 0, 2) . '.' . substr($value, 2, 3) . '.' . substr($value, 5, 3) .
            '/' . substr($value, 8, 4) . '-' . substr($value, 12, 2);
    }

    public function setCepAttribute($value)
    {
        $this->attributes['cep'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function getCepAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return substr($value, 0, 5) . '-' . substr($value, 5, 3);
    }

    public function setTelefoneAttribute($value)
    {
        $this->attributes['telefone'] = (!empty($value) ? $this->clearField($value) : null);
    }
    //Formata o telefone para exibir
    public function getTelefoneAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return  
            substr($value, 0, 0) . '(' .
            substr($value, 0, 2) . ') ' .
            substr($value, 2, 4) . '-' .
            substr($value, 6, 4) ;
    }
    
    public function setCelularAttribute($value)
    {
        $this->attributes['celular'] = (!empty($value) ? $this->clearField($value) : null);
    }
    //Formata o celular para exibir
    public function getCelularAttribute($value)
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
    //Formata o celular para exibir
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

    public function setExibirnoguiaAttribute($value)
    {
        $this->attributes['exibirnoguia'] = ($value == '1' ? 1 : 0);
    }

    public function setSlug()
    {
        if(!empty($this->alias_name)){
            $empresa = Empresa::where('alias_name', $this->alias_name)->first(); 
            if(!empty($empresa) && $empresa->id != $this->id){
                $this->attributes['slug'] = Str::slug($this->alias_name) . '-' . $this->id;
            }else{
                $this->attributes['slug'] = Str::slug($this->alias_name);
            }            
            $this->save();
        }
    }

    private function clearField(?string $param)
    {
        if(empty($param)){
            return null;
        }

        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
