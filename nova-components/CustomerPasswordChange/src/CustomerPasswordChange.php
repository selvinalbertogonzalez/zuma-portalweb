<?php

namespace Zuma\CustomerPasswordChange;

use Laravel\Nova\ResourceTool;

class CustomerPasswordChange extends ResourceTool {
    /**
     * Get the displayable name of the resource tool.
     *
     * @return string
     */
    public function name() {
        return 'Cambio de contraseña';
    }

    /**
     * Get the component name for the resource tool.
     *
     * @return string
     */
    public function component() {
        return 'customer-password-change';
    }
}
