<?php

namespace App\Nova;

use App\Nova\Actions\ZumaUserConfiguration;
use App\Nova\Actions\ZumaUserExport;
use App\Nova\Filters\ConfiguredUser;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Boolean;
use Laravel\Nova\Fields\Text;
use Zuma\CustomerPasswordChange\CustomerPasswordChange;
use Zuma\PosConfig\PosConfig;

class ZumaUser extends Resource {
    public static function label() {
        return 'Clientes';
    }
    /**
     *
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\ZumaUser::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'Correo';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'NombreNegocio',
        'Correo',
        'Celular',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request) {
        return [
            Text::make('Negocio', 'NombreNegocio')->sortable(),
            Text::make('Correo', 'Correo')->sortable(),
            Text::make('Celular', 'Celular')->sortable(),
            Text::make('No. Serial', 'serial')->sortable(),
            Boolean::make('Configurado', function () {
                return $this->affiliation != null;
            }),
            PosConfig::make(),
            CustomerPasswordChange::make(),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request) {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request) {
        return [
            new ConfiguredUser,
        ];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request) {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request) {
        return [(new ZumaUserConfiguration)
                ->confirmText('¿Desea configurar el usuario?')
                ->confirmButtonText('Configurar')
                ->cancelButtonText("No configurar")
                ->onlyOnTableRow()
                ->canRun(function ($request, $user) {
                    return true;
                }),
            (new ZumaUserExport)
                ->onlyOnIndex()
                ->canRun(function ($request, $user) {
                    return true;
                }),

        ];
    }
}
