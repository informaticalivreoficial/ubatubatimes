<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $table = 'plans'; 
    
    protected $fillable = [
        'name',
        'content',
        'slug',
        'exibivalores',
        'status',
        'avaliacao',   
        'tipo_pagamento',
        'valor_mensal',
        'valor_trimestral',
        'valor_semestral',
        'valor_anual'
    ];

    /**
     * Relacionamentos
    */
    public function anuncios()
    {
        return $this->hasMany(Anuncio::class, 'plan_id', 'id');
        //return $this->belongsToMany(Anuncio::class);
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
    
    // public function profilesAvailable()
    // {
    //     $profiles = Profile::whereNotIn('id', function($query){
    //         $query->select('plan_profile.profile_id');
    //         $query->from('plan_profile');
    //         $query->whereRaw("plan_profile.plan_id={$this->id}");
    //     })->paginate();
        
    //     return $profiles;
    // }

    /**
     * Accerssors and Mutators
    */
    

    private function convertStringToDouble($param)
    {
        if(empty($param)){
            return null;
        }
        return str_replace(',', '.', str_replace('.', '', $param));
    }
}
