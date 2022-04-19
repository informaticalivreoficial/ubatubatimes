<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anuncio extends Model
{
    use HasFactory;

    protected $table = 'anuncios';

    protected $fillable = [
        'empresa',
        'categoria',
        'plan_id',
        '300x250',
        '728x90',
        '468x90',
        '336x280',
        'titulo',
        'slug',
        'posicao',
        'status',
        'subscription_id',
        'subscription',
        'expires_at',
        'subscription_active',
        'subscription_suspended',
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
    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa', 'id');
    }

    public function plano()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    /**
     * Accerssors and Mutators
    */
}
