<?php

declare(strict_types=1);

namespace App\Response\Dependency;

use App\Response\Response;
use App\Response\ResponseInterface;

/**
 * Class to binding response interface -> response concret class.
 */
class ResponseDependency
{
    /**
     * Method to be called static and get bindings.
     *
     * @return array
     */
    public static function getBindings(): array
    {
        return [
            ResponseInterface::class => Response::class,
        ];
    }
}
