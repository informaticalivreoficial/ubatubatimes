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
        'end_date' => 'date',
        'active' => 'boolean',
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

    // 🔥 helper pronto pra usar no Blade
    public static function getBySlug($slug)
    {
        return self::whereHas('plan', fn ($q) => $q->where('slug', $slug))
            ->where('active', true)
            ->whereHas('company.invoices', function ($q) {
                $q->where('status', 'paid');
            })
            ->whereDate('start_date', '<=', now())
            ->whereDate('end_date', '>=', now())
            ->inRandomOrder()
            ->first();
    }

    public function isActive()
    {
        return $this->active &&
            $this->start_date <= now() &&
            $this->end_date >= now() &&
            $this->company->invoices()
                ->where('status', 'paid')
                ->exists();
    }
}
