<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    use HasFactory;

    protected $table = 'faturas';

    protected $fillable = [
        'anuncio',
        'empresa',
        'transaction_id',
        'paid_date',
        'vencimento',
        'pedido',
        'valor',
        'status'      
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
    public function getEmpresa()
    {
        return $this->hasOne(Empresa::class, 'id', 'empresa');
    }
    public function getAnuncio()
    {
        return $this->hasOne(Anuncio::class, 'id', 'anuncio');
    }

    /**
     * Accerssors and Mutators
    */
    public function setValorMensalAttribute($value)
    {
        $this->attributes['valor_mensal'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    private function convertStringToDouble($param)
    {
        if(empty($param)){
            return null;
        }
        return str_replace(',', '.', str_replace('.', '', $param));
    }
}
