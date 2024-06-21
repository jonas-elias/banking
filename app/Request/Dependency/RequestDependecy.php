<?php

declare(strict_types=1);

namespace App\Request\Dependency;

use App\Request\Request;
use App\Request\RequestInterface;

/**
 * Class to binding request interface -> request concret class.
 */
class RequestDependecy
{
    /**
     * Method to be called static and get bindings.
     *
     * @return array
     */
    public static function getBindings(): array
    {
        return [
            RequestInterface::class => Request::class,
        ];
    }
}
