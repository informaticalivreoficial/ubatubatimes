<?php

namespace App\Services;

use App\Repositories\EmpresaRepository;

class EmpresaService
{
    private $empresaRepository;

    public function __construct(EmpresaRepository $empresaRepository)
    {
        $this->empresaRepository = $empresaRepository;
    }

    public function listEmpresas()
    {
        $empresas = $this->empresaRepository->getEmpresas();
        return $empresas;
    }

    public function setCover(int $gbId)
    {      
        $setCover =  $this->empresaRepository->gbSetCover($gbId);
        if($setCover){
            return ['success' => true];
        }          
    }

    public function imageRemoveGb(int $id)
    {      
        $image =  $this->empresaRepository->removeGb($id);
        if($image){
            return ['success' => true];
        }          
    }

    public function imageRemoveGbAll(int $id)
    {      
        return  $this->empresaRepository->removeGbAll($id);
    }

    public function getGbImage(int $fk)
    {
        return $this->empresaRepository->getGb($fk);
    }
}