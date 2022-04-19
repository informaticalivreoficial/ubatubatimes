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
}