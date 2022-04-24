<?php

namespace App\Repositories;

use App\Models\Empresa;
use App\Models\EmpresaGb;
use App\Support\Cropper;
use Illuminate\Support\Facades\Storage;

class EmpresaRepository
{
    private $model, $modelGb;

    public function __construct(Empresa $model, EmpresaGb $modelGb)
    {
        $this->model = $model;
        $this->modelGb = $modelGb;
    }

    public function getEmpresas()
    {
        $empresas = $this->model->latest()->get();
        return $empresas;
    }

    public function getGb(int $fk)
    {
        $gb = $this->modelGb->where('empresa', $fk)->first();
        return $gb;
    }

    public function gbSetCover(int $gbId)
    {
        $imageSetCover = $this->modelGb->where('id', $gbId)->first();
        $allImage = $this->modelGb->where('empresa', $imageSetCover->empresa)->get();

        foreach ($allImage as $image) {
            $image->cover = null;
            $image->save();
        }

        $imageSetCover->cover = true;
        $imageSetCover->save();
        return true;
    }

    public function removeGb(int $id)
    {      
        $imageDelete = $this->modelGb->where('id', $id)->first();
        Storage::delete($imageDelete->path);
        Cropper::flush($imageDelete->path);
        $imageDelete->delete();
        return true;          
    }

    public function removeGbAll(int $id)
    {      
        $imageDelete = $this->modelGb->where('empresa', $id)->first();
        Storage::delete($imageDelete->path);
        Cropper::flush($imageDelete->path);
        $imageDelete->delete();
        Storage::deleteDirectory('empresas/'.$id);
    }
}