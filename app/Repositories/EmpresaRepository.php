<?php

namespace App\Repositories;

use App\Models\CatEmpresa;
use App\Models\Empresa;
use App\Models\EmpresaGb;
use App\Support\Cropper;
use Illuminate\Support\Facades\Storage;

class EmpresaRepository
{
    private $model, $modelGb, $modelCategorias, $paginate = null;

    public function __construct(Empresa $model, EmpresaGb $modelGb, CatEmpresa $modelCategorias)
    {
        $this->model = $model;
        $this->modelGb = $modelGb;
        $this->modelCategorias = $modelCategorias;
    }

    public function getEmpresas($paginate)
    {
        //$paginate = ($paginate == null ? $this->paginate : $paginate);
        $empresas = $this->model->latest()->orderBy('status', 'ASC')->paginate($paginate);
        return $empresas;
    }

    public function getById(int $id)
    {
        $empresa = $this->model->where('id', $id)->first();
        return $empresa;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, int $id)
    {
        $empresa = $this->getById($id);
        $empresa->fill($data);
        $empresa->save(); 
        return $this->model->where('id', $id)->firstOrfail();
    }

    public function getCategorias()
    {
        //
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
        $imageDelete->delete();
        return true;          
    }

    public function removeGbAll(int $id)
    {      
        $imageDelete = $this->modelGb->where('empresa', $id)->first();
        Storage::delete($imageDelete->path);
        $imageDelete->delete();
        Storage::deleteDirectory('empresas/'.$id);
    }
}