<?php

declare(strict_types=1);

namespace App\DTO\Contract;

use App\Request\RequestInterface;

/**
 * User DTO interface rule methods.
 */
interface BaseDTOInterface
{
    /**
     * Method to capture request params and return static object DTO.
     *
     * @param $request
     *
     * @return static
     */
    public static function fromRequest(RequestInterface $request): static;
}
