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
        'valor',
        'status',
        'url_slip',
        'url_slip_pdf',
        'digitable_line'
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
    public function getStatus()
    {
        if(!empty($this->status) && $this->status == 'pending'){
            return '<span class="badge bg-warning">Aguardando</span>';
        }
    }

    

    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    

    // public function setVencimentoAttribute($value)
    // {
    //     $this->attributes['vencimento'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    // }

    

    private function convertStringToDouble($param)
    {
        if(empty($param)){
            return null;
        }
        return str_replace(',', '.', str_replace('.', '', $param));
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
        if(empty($param)){
            return null;
        }

        return str_replace(['.', '-', '/', '(', ')', ' '], '', $param);
    }
}
