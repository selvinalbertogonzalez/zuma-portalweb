<?php

namespace Zuma\PosConfig;

use Laravel\Nova\ResourceTool;

class PosConfig extends ResourceTool {
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name() {
        return 'Configuración de POS';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component() {
        return 'pos-config';
    }
}
