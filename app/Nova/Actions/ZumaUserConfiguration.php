<?php

namespace App\Nova\Actions;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ZumaUserConfiguration extends Action {
    use InteractsWithQueue, Queueable;

    public $name = 'Configuración VISA';
    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models) {
        $m = $models->first();

        return Action::redirect('/visa-config?email=' . $m->Correo);
    }

    /**
     * Get the fields available on the action.
     *
     * @return array
     */
    public function fields() {
        return [];
    }
}
