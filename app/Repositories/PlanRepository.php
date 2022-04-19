<?php

namespace App\Repositories;

use App\Models\Plan;

class PlanRepository
{
    private $model;

    public function __construct(Plan $model)
    {
        $this->model = $model;
    }

    public function getPlans()
    {
        $plans = $this->model->latest()->get();
        return $plans;
    }
}