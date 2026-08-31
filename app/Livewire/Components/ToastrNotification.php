<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ToastrNotification extends Component
{
    public ?array $flashToast = null;

    public function mount(): void
    {
        if (session()->has('toast')) {
            $this->flashToast = session()->pull('toast');
        }
    }

    public function render()
    {
        return view('livewire.components.toastr-notification');
    }
}
