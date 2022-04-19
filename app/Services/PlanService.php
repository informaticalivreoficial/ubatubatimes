<?php

namespace App\Services;

use App\Repositories\PlanRepository;

class PlanService
{
    private $planRepository;

    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function listPlans()
    {
        $plans = $this->planRepository->getPlans();
        return $plans;
    }
}