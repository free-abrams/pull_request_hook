<?php

namespace App\Service;

use Illuminate\Support\Facades\Facade;

class WebHook extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'cache';
    }
}
