<?php

namespace App\Observers;

use App\Models\Departamento;

class DepartamentoObserver
{
    /**
     * Handle the Departamento "created" event.
     */
    public function creating(Departamento $departamento): void
    {
    }
    public function created(Departamento $departamento): void
    {
        //
        $departamento->empleados()->update(['encargado_id' => $departamento->encargado_id]);
        $departamento->encargado()->update(['departamento_id' => $departamento->departamento_id]);
    }

    public function updating(Departamento $departamento): void
    {
    }
    /**
     * Handle the Departamento "updated" event.
     */
    public function updated(Departamento $departamento): void
    {
        //
        if ($departamento->isDirty('encargado_id')) {
            if (is_null($departamento->encargado_id)) {
                $departamento->empleados()->update(['encargado_id' => null]);
            } else {
                $departamento->empleados()->update(['encargado_id' => $departamento->encargado_id]);
                $departamento->encargado()->update(['departamento_id' => $departamento->departamento_id]);
            }
        }
    }

    public function deleting(Departamento $departamento): void
    {
        $departamento->empleados()->update(['departamento_id' => null]);
        $departamento->empleados()->update(['encargado_id' => null]);
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
