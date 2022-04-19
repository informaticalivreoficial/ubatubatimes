<?php

namespace App\Repositories;

use App\Models\Empresa;

class EmpresaRepository
{
    private $model;

    public function __construct(Empresa $model)
    {
        $this->model = $model;
    }

    public function getEmpresas()
    {
        $empresas = $this->model->latest()->get();
        return $empresas;
    }
}