<?php

namespace App\Nova\Actions;

use App\Export\UserExport;
use Excel;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Collection;
use Laravel\Nova\Actions\Action;
use Laravel\Nova\Fields\ActionFields;

class ZumaUserExport extends Action {
    use InteractsWithQueue, Queueable;

    public $name = 'Exportar clientes';

    /**
     * Perform the action on the given models.
     *
     * @param  \Laravel\Nova\Fields\ActionFields  $fields
     * @param  \Illuminate\Support\Collection  $models
     * @return mixed
     */
    public function handle(ActionFields $fields, Collection $models) {
        $path = Excel::store(new UserExport($models), 'Clientes.xlsx');

        return Action::download($path, 'Clientes.xlsx');
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
