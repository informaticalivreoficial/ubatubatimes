<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CatAnuncio extends Model
{
    use HasFactory;

    protected $table = 'cat_anuncios';

    protected $fillable = [
        'titulo',
        'content',
        'slug',
        'tags',
        'tipo',
        'status',
        'views',
        'id_pai'
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
    public function children()
    {
        return $this->hasMany(CatAnuncio::class, 'id_pai', 'id');
    }

    /**
     * Accerssors and Mutators
     */
    public function getStatusAttribute($value)
    {
        if(empty($value)){
            return null;
        }

        return ($value == '1' ? 'Sim' : 'Não');
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = ($value == '1' ? 1 : 0);
    }

    public function countAnuncios()
    {
        return $this->hasMany(Anuncio::class, 'categoria', 'id')->count();
    }

    public function setSlug()
    {
        if(!empty($this->titulo)){
            $categoria = CatAnuncio::where('titulo', $this->titulo)->first(); 
            if(!empty($categoria) && $categoria->id != $this->id){
                $this->attributes['slug'] = Str::slug($this->titulo) . '-' . $this->id;
            }else{
                $this->attributes['slug'] = Str::slug($this->titulo);
            }            
            $this->save();
        }
    }
}
