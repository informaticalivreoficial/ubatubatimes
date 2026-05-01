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
    
    public function getFallbackImageUrl(): string
    {
        return match($this->width) {
            728  => asset('theme/images/banner728x90.jpg'),
            300  => asset('theme/images/banner300x250.jpg'),
            default => asset('theme/images/banner728x90.jpg'),
        };
    }
}
