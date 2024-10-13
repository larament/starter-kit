<?php

use App\Models\Option;

if (! function_exists('get_option')) {
    /**
     * Get the specified option value.
     */
    function get_option(string $name, $default = null)
    {
        return Option::get($name, $default);
    }
}
