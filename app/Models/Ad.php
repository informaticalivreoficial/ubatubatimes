<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'plan_id',
        'ad_contract_id',
        'title',
        'image',
        'link',
        'start_date',
        'end_date',
        'active',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'active'     => 'boolean',
    ];

    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function contract()
    {
        return $this->belongsTo(AdContract::class, 'ad_contract_id');
    }

    public function isActive(): bool
    {
        $validDate = $this->start_date->lte(now()) &&
            (!$this->end_date || $this->end_date->gte(now()));

        $validPayment = $this->contract->free
            || $this->company->invoices()->where('status', 'paid')->exists();

        return $this->active && $validDate && $validPayment;
    }

    public function scopeActive($query)
    {
        return $query->where('active', true)
            ->whereDate('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                ->orWhereDate('end_date', '>=', now());
            });
    }

    // 🔥 helper pronto pra usar no Blade
    public static function getBySlug(string $slug): ?self
    {
        return self::whereHas('plan', fn ($q) => $q->where('slug', $slug))
            ->where('active', true)
            ->whereDate('start_date', '<=', now())
            ->where(function ($q) {
                $q->whereNull('end_date')
                ->orWhereDate('end_date', '>=', now());
            })
            ->whereHas('contract', function ($q) {
                $q->where(function ($q) {
                    // free não precisa de fatura paga
                    $q->where('free', true)
                    ->orWhereHas('invoices', fn ($q) => $q->where('status', 'paid'));
                });
            })
            ->inRandomOrder()
            ->first();
    }
}
