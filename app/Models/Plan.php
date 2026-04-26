<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'width',
        'height',
        'active',
    ];

    public function ads()
    {
        return $this->hasMany(Ad::class);
    }

    public function contracts()
    {
        return $this->hasMany(AdContract::class);
    }
}
