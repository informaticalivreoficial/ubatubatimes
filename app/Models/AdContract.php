<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdContract extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'plan_id',
        'price',
        'start_date',
        'end_date',
        'auto_renew',
        'active',
        'free',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'auto_renew' => 'boolean',
        'active' => 'boolean',
        'free' => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    /*
    |--------------------------------------------------------------------------
    | HELPERS
    |--------------------------------------------------------------------------
    */

    public function isActive(): bool
    {
        return $this->active &&
            $this->start_date->lte(now()) &&
            (!$this->end_date || $this->end_date->gte(now()));
    }

    public function hasValidPayment(): bool
    {
        // Contrato free não precisa de pagamento
        if ($this->free) return true;

        return $this->invoices()
            ->where('status', 'paid')
            ->exists();
    }

    public function isRunning()
    {
        return $this->isActive() && $this->hasValidPayment();
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeRunning($query)
    {
        return $query->where('active', true)
            ->whereDate('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhereDate('end_date', '>=', now());
            });
    }

    public function scopeExpired($query)
    {
        return $query->whereDate('end_date', '<', now());
    }

    public function scopeFree($query)
    {
        return $query->where('free', true);
    }

    public function scopePaid($query)
    {
        return $query->where('free', false);
    }

    /*
    |--------------------------------------------------------------------------
    | ACTIONS
    |--------------------------------------------------------------------------
    */

    public function generateInvoice(int $dueDays = 3): ?Invoice
    {
        // Contrato free não gera fatura
        if ($this->free) return null;

        return Invoice::create([
            'company_id'     => $this->company_id,
            'ad_contract_id' => $this->id,
            'amount'         => $this->price,
            'due_date'       => now()->addDays($dueDays),
        ]);
    }
}
