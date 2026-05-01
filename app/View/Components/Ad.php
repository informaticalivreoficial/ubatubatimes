<?php

namespace App\View\Components;

use App\Models\Ad as ModelsAd;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Ad extends Component
{
    public $slotName;
    public $ad;
    public $plan;

    public function __construct($slot)
    {
        $this->slotName = $slot;
        $this->ad = ModelsAd::getBySlug($slot);
        $this->plan     = \App\Models\Plan::where('slug', $slot)->first();
    }

    public function render(): View|Closure|string
    {
        return view('components.ad');
    }
}
