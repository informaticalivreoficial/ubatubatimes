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

    public function listEmpresas($paginate = null)
    {
        $empresas = $this->empresaRepository->getEmpresas($paginate);
        return $empresas;
    }

    public function listAllEmpresas()
    {
        $empresas = $this->empresaRepository->getAllEmpresas();
        return $empresas;
    }

    public function listCategorias($paginate = null)
    {
        $categorias = $this->empresaRepository->getCategorias($paginate);
        return $categorias;
    }

    public function getEmpresaById(int $id)
    {
        $empresa = $this->empresaRepository->getById($id);
        return $empresa;
    }

    public function setStatus(int $id, int $status)
    {      
        $data['status'] = $status;
        $empresa = $this->empresaRepository->update($data, $id);
        if($empresa){
            return ['success' => true];
        }
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