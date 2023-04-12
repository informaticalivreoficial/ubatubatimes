<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Support\Cropper;
use Illuminate\Support\Str;

class Anuncio extends Model
{
    use HasFactory;

    protected $table = 'anuncios';

    protected $fillable = [
        'empresa',
        'plan_id',
        '300x250',
        '728x90',
        '468x90',
        '336x280',
        'titulo',
        'slug',
        'link',
        'posicao',
        'status',
        'vencimento',
        'periodo',
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

    public function empresaObject()
    {
        return $this->hasOne(Empresa::class, 'id', 'empresa');
    }

    public function plano()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function countfaturas()
    {
        return $this->hasMany(Fatura::class, 'anuncio', 'id')->count();
    }

    /**
     * Accerssors and Mutators
    */
    public function position()
    {
        $position = [
            ['id' => 1,'name' => 'Home Sidebar 300x250'],
            ['id' => 2,'name' => 'Topo home 728x90'],
            ['id' => 3,'name' => 'Artigo Sidebar 300x250'],
            ['id' => 4,'name' => 'Notícia Sidebar 300x250'],
            ['id' => 5,'name' => 'Home Main Footer 728x90'],
            ['id' => 6,'name' => 'Notícia Main Footer 728x90'],
            ['id' => 7,'name' => 'Blog Main Footer 728x90'],
            ['id' => 8,'name' => 'Boletim das Ondas Sidebar 300x250'],
            ['id' => 9,'name' => 'Home Main Center 728x90'],
            ['id' => 10,'name' => 'Artigo Main Footer 728x90']
        ];

        return $position;
    }

    public function get300x250()
    {
        $image = $this['300x250'];        
        if(empty($this['300x250']) || !Storage::disk()->exists($image)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 
        return Storage::url($this['300x250']);
    }
    
    public function get468x90()
    {
        $image = $this['468x90'];        
        if(empty($this['468x90']) || !Storage::disk()->exists($image)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 
        //return Storage::url(Cropper::thumb($this['468x90'], 468, 90));
        return Storage::url($this['468x90']);
    }

    public function get336x280()
    {
        $image = $this['336x280'];        
        if(empty($this['336x280']) || !Storage::disk()->exists($image)) {
            return url(asset('backend/assets/images/image.jpg'));
        } 
        //return Storage::url(Cropper::thumb($this['336x280'], 336, 280));
        return Storage::url($this['336x280']);
    }

    public function get728x90()
    {
        $image = $this['728x90'];        
        if(empty($this['728x90']) || !Storage::disk()->exists($image)) {
            return url(asset('backend/assets/images/image.jpg'));
        }         
        return Storage::url($this['728x90']);
    }

    public function setSlug()
    {
        if(!empty($this->titulo)){
            $anuncio = Anuncio::where('titulo', $this->titulo)->first(); 
            if(!empty($anuncio) && $anuncio->id != $this->id){
                $this->attributes['slug'] = Str::slug($this->titulo) . '-' . $this->id;
            }else{
                $this->attributes['slug'] = Str::slug($this->titulo);
            }            
            $this->save();
        }
    }
}
