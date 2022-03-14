<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Support\Cropper;

class Produto extends Model
{
    use HasFactory;

    protected $table = 'produtos';

    protected $fillable = [
        'categoria',
        'name',
        'content',
        'headline',
        'slug',
        'tags',
        'views',
        'cat_pai',        
        'comentarios',        
        'status',
        'exibir',
        'ativacao',
        'tipo_pagamento',
        'thumb_legenda',
        'publish_at',
        'exibivalores',        
        'valor',
        'valor_mensal',
        'valor_trimestral',
        'valor_semestral',
        'valor_anual',
        'valor_bianual'
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

    public function scopeExibir($query)
    {
        return $query->where('exibir', 1);
    }

    public function images()
    {
        return $this->hasMany(ProdutoGb::class, 'produto', 'id')->orderBy('cover', 'ASC');
    }
    
    public function countimages()
    {
        return $this->hasMany(ProdutoGb::class, 'produto', 'id')->count();
    }

    /**
     * Accerssors and Mutators
     */

    public function getContentWebAttribute()
    {
        return Str::words($this->content, '20', ' ...');
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
            return url(asset('backend/assets/images/image.jpg'));
        }

        return Storage::url(Cropper::thumb($cover['path'], 960, 1100));
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
            return url(asset('backend/assets/images/image.jpg'));
        }

        return Storage::url($cover['path']);
    } 

    public function setTipopagamentoAttribute($value)
    {
        $this->attributes['tipo_pagamento'] = ($value == true || $value == '1' ? 1 : 0);
    }

    public function setExibirAttribute($value)
    {
        $this->attributes['exibir'] = ($value == true || $value == '1' ? 1 : 0);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function getPublishAtAttribute($value)
    {
        if (empty($value)) {
            return null;
        }
        return date('d/m/Y', strtotime($value));
    }

    public function setSlug()
    {
        if(!empty($this->name)){
            $produto = Produto::where('name', $this->name)->first(); 
            if(!empty($produto) && $produto->id != $this->id){
                $this->attributes['slug'] = Str::slug($this->name) . '-' . $this->id;
            }else{
                $this->attributes['slug'] = Str::slug($this->name);
            }            
            $this->save();
        }
    }

    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setValorMensalAttribute($value)
    {
        $this->attributes['valor_mensal'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorMensalAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setValorTrimestralAttribute($value)
    {
        $this->attributes['valor_trimestral'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorTrimestralAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setValorSemestralAttribute($value)
    {
        $this->attributes['valor_semestral'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorSemestralAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setValorAnualAttribute($value)
    {
        $this->attributes['valor_anual'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorAnualAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    public function setValorBianualAttribute($value)
    {
        $this->attributes['valor_bianual'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function getValorBianualAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return number_format($value, 2, ',', '.');
    }

    private function convertStringToDouble($param)
    {
        if(empty($param)){
            return null;
        }
        return str_replace(',', '.', str_replace('.', '', $param));
    }
}
