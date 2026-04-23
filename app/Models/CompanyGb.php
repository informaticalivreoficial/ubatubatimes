<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanyGb extends Model
{
    use HasFactory;

    protected $table = 'company_gbs'; 

    protected $fillable = [
        'company',
        'order_img',
        'watermark',        
        'path',
        'cover'
    ];

    /**
     * Accerssors and Mutators
    */
    public function getUrlCroppedAttribute()
    {
        return Storage::url($this->path);
    }

    public function getUrlImageAttribute()
    {
        return Storage::url($this->path);
    }
}
