<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Empresa;

class EmpresaObserver
{
    /**
     * Handle the Tenant "creating" event.
     *
     * @param  \App\Models\Tenant  $tenant
     * @return void
     */
    public function creating(Empresa $empresa)
    {
        $empresa->uuid = (string) Str::uuid();
        $empresa->slug = (string) Str::slug($empresa->alias_name);
    }

    public function updating(Empresa $empresa)
    {
        $empresa->slug = (string) Str::slug($empresa->alias_name);
    }
}
