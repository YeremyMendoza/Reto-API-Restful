<?php

namespace App\Observers;

use App\Models\Departamento;

class DepartamentoObserver
{
    /**
     * Handle the Departamento "created" event.
     */
    public function created(Departamento $departamento): void
    {
        //
    }

    /**
     * Handle the Departamento "updated" event.
     */
    public function updated(Departamento $departamento): void
    {
        //
    }

    public function deleting(Departamento $departamento): void
    {
        $departamento->empleados()->update(['departamento_id' => null]);
    }
    /**
     * Handle the Departamento "deleted" event.
     */
    public function deleted(Departamento $departamento): void
    {
        //
    }

    /**
     * Handle the Departamento "restored" event.
     */
    public function restored(Departamento $departamento): void
    {
        //
    }

    /**
     * Handle the Departamento "force deleted" event.
     */
    public function forceDeleted(Departamento $departamento): void
    {
        //
    }
}
