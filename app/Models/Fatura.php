<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fatura extends Model
{
    use HasFactory;

    protected $table = 'faturas';

    protected $fillable = [
        'nome',
        'pfpf',
        'pfpj',
        'email',
        'telefone',
        'cpf',
        'company',
        'alias_name',
        'cnpj',
        'titulo',
        'tipo_boleto',
        'numero_parcelas',

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
    public function getStatus()
    {
        if(!empty($this->status) && $this->status == 'pending'){
            return '<span class="badge bg-warning">Aguardando</span>';
        }
    }

    public function setPfpfAttribute($value)
    {
        $this->attributes['pfpf'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setPfpjAttribute($value)
    {
        $this->attributes['pfpj'] = ($value == true || $value == 'on' ? 1 : 0);
    }

    public function setValorAttribute($value)
    {
        $this->attributes['valor'] = (!empty($value) ? floatval($this->convertStringToDouble($value)) : null);
    }

    public function setCpfAttribute($value)
    {
        $this->attributes['cpf'] = (!empty($value) ? $this->clearField($value) : null);
    }

    public function setCnpjAttribute($value)
    {
        $this->attributes['cnpj'] = (!empty($value) ? $this->clearField($value) : null);
    }

    // public function setVencimentoAttribute($value)
    // {
    //     $this->attributes['vencimento'] = (!empty($value) ? $this->convertStringToDate($value) : null);
    // }

    public function setTelefoneAttribute($value)
    {
        $this->attributes['telefone'] = (!empty($value) ? $this->clearField($value) : null);
    }

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
